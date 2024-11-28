<?php
namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\WavePaymentService;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    // public function pay(Request $request, WavePaymentService $wavePaymentService)
    // {
    //     $user = auth()->user();
    //     $month = $request->input('month');
    //     $totalToPay = $request->input('total_to_pay');

    //     // Vérifiez si un paiement existe déjà pour la période spécifiée
    //     if (Payment::where('user_id', $user->id)->where('payment_period', Carbon::parse($month)->format('Ym'))->exists()) {
    //         return redirect()->route('user.monthlyInvoice')->with('error', 'Vous avez déjà effectué un paiement pour ce mois.');
    //     }

    //     // Initier le paiement via Wave
    //     $response = $wavePaymentService->initiatePayment($totalToPay);

    //     // Si la réponse contient une URL de redirection, redirigez l'utilisateur
    //     if (isset($response['checkout_url'])) {
    //         return redirect($response['checkout_url']);
    //     }

    //     return redirect()->route('user.monthlyInvoice')->with('error', "Impossible d'initier le paiement. Veuillez réessayer.");
    // }

    public function pay(
        PaymentRequest $request
    ) {
        $payment_period = $request->input('payment_period');
        $amount = $request->input('amount');
        $method = $request->input('method');

        $payment = Payment::query()
            ->where('user_id', $request->user()->id)
            ->where('payment_period', $payment_period)
            ->where('payment_status', 'pending')
            ->first();

        if (!$payment) {
            $payment = Payment::create([
                'user_id' => $request->user()->id,
                'amount' => $amount, 
                'payment_period' => $payment_period,
                'token' => Str::uuid()->toString(),
                'payment_method' => $method,
            ]);
        } else {
            if ( $payment->payment_method != $method ) {
                $payment->payment_method = $method;
                $payment->save();
            }
        }

        if ($method == "wave") {
            $response = Http::withToken(config('payments.wave.auth_bearer'))
            ->post(config('payments.wave.url'), [
                "amount"=> app()->environment('production') ? $payment->amount : 100,
                "currency" => config('payments.wave.currency'),
                'client_reference' => $payment->token,
                "error_url" => "http://localhost:8000/payment/error",
                "success_url" => "http://localhost:8000/payment/success"
            ]);

                $result = $response->json();
                //$result["wave_launch_url"];
                return redirect()->away($result["wave_launch_url"]);
        } elseif ($method == "orange-money") {
    }

    }

    public function paymentSuccess()
    {
        // Traitez la confirmation de paiement
        return view('user.payment.index')->with('success', 'Paiement effectué avec succès.');
    }

    public function paymentError()
    {
        // Traitez les erreurs de paiement
        return view('user.payment.index')->with('error', 'Échec du paiement.');
    }

    public function notification(Request $request)
    {
        // if (!$this->webhookIsOk()) {
        //     Log::error(
        //         ''
        //     )
        //     return false;
        // }

        $content = $request->post();
        $token = Arr::get($content, 'data.client_reference');
        $payment = Payment::query()
            ->where('token', $token)
            ->where('payment_status', 'pending')
            ->first();

        $paymentSucceded = Arr::get($content, 'data.checkout_status') == "complete"
            && Arr::get($content, 'data.payment_status') == "succeeded";

        if (app()->environment('production')) {
            $paymentSucceded = Arr::get($content, 'data.amount') == $payment->amount
                && $paymentSucceded;
        }

        if ($paymentSucceded) {
            //Paiement réussi
            $payment->update(['payment_status' => 'paid']);

            // Mettre à jour le statut des commandes associées
            Order::query()
            ->where('user_id', $payment->user_id)
            ->where('payment_status', 'pending')
            ->update(['payment_status' => 'paid']);
        }

        //dd($request->header('HTTP_WAVE_SIGNATURE'));
        dd(Arr::get($content, 'data.client_reference'));
    }

    public function webhookIsOk(
        $wave_webhook_secret,
        $wave_signature,
        $webhook_body
    ) {
        $parts = explode(",", $wave_signature);
        $timestamp = explode("=", $parts[0])[1];

        $signatures = array();
        foreach (array_slice($parts, 1) as $signature) {
            $signatures[] = explode("=", $signature)[1];
        }

        $computed_hmac = hash_hmac("sha256", $timestamp . $webhook_body, $wave_webhook_secret);

        return in_array($computed_hmac, $signatures);
    }
}

