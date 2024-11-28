<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WavePaymentService
{
    protected $apiUrl;
    protected $authBearer;
    protected $currency;
    protected $webhookSecret;

    public function __construct()
    {
        $this->apiUrl = config('services.wave.url');
        $this->authBearer = config('services.wave.auth_bearer');
        $this->currency = config('services.wave.currency');
        $this->webhookSecret = config('services.wave.webhook_secret');
    }

    public function initiatePayment($amount)
    {
        // Créer une session de paiement avec Wave
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->authBearer,
        ])->post($this->apiUrl, [
            'amount' => $amount,
            'currency' => $this->currency,
            'success_url' => route('payment.success'), // URL de succès
            'error_url' => route('payment.error'),    // URL d'erreur
        ]);

        return $response->json();
    }

    public function checkPaymentStatus($transactionId)
    {
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->authBearer,
        ])->get("{$this->apiUrl}/{$transactionId}");

        return $response->json();
    }

}
