<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $orders = Order::all();
         return view('admin.orders.index', compact('orders'));
    }


    public function showOrderOfTheDay()
    {
        $order = Order::getOfOrderOfTheDay()->first(); 
        return view('admin.orders.showOrderOfTheDay', ['order' => $order]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id, $month)
    {
        // Récupérer l'utilisateur
        $user = User::findOrFail($user_id);

        // Convertir le mois sélectionné en objet Carbon
        $date = Carbon::parse($month);

        // Récupérer les commandes de l'utilisateur pour le mois donné
        $orders = Order::where('user_id', $user_id)
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->with(['orderItems.menuItems.items', 'orderItems.menuItems.items.restaurants'])
                    ->get();

        // Calculer le total des sous-totaux pour le mois donné
        $totalPrice = $orders->map(function ($order) {
            return $order->orderItems->sum(function ($orderItem) {
                return $orderItem->unit_price * $orderItem->quantity;
            });
        })->sum();

        // Retourner la vue avec les données
        return view('admin.orders.show', compact('user', 'orders', 'month', 'totalPrice'));
    }


    public function pay(Request $request)
    {
        // Récupérer les informations de la demande
        $userId = $request->input('user_id');
        $month = $request->input('month');
        $totalToPay = $request->input('total_to_pay');

        // Implémentez la logique de paiement ici.
        // Par exemple : Mettre à jour le statut de paiement, enregistrer la transaction, etc.

        // Message de confirmation et redirection après le paiement
        return redirect()->route('admin.reports.monthly')->with('success', "Le paiement de {$totalToPay} frcs CFA pour l'utilisateur {$userId} a été effectué avec succès pour le mois de {$month}.");
    }


public function monthlyReport(Request $request)
{
    // Récupérer les utilisateurs pour le filtre
    $users = User::all();

    // Récupérer les paramètres de recherche (utilisateur et mois)
    $userId = $request->input('user_id');
    $month = $request->input('month');

    // Si aucun mois n'est sélectionné, utilisez le mois et l'année actuels
    if (!$month) {
        $month = Carbon::now()->format('Y-m'); // Format "YYYY-MM" pour correspondre à l'input type="month"
    }

    // Construire la requête pour obtenir le total des commandes par utilisateur et par mois
    $ordersQuery = Order::selectRaw('user_id, SUM(price) as total_price')
        ->groupBy('user_id')
        ->with('user'); // Charger les informations de l'utilisateur associé

    // Filtrer par utilisateur si un utilisateur est sélectionné
    if ($userId) {
        $ordersQuery->where('user_id', $userId);
    }

    // Filtrer par mois (par défaut, mois actuel si non sélectionné)
    $ordersQuery->whereMonth('created_at', Carbon::parse($month)->month)
                ->whereYear('created_at', Carbon::parse($month)->year);

    // Obtenir les commandes agrégées
    $orders = $ordersQuery->get();

    return view('admin.reports.monthly', compact('orders', 'users', 'userId', 'month'));
}




    


    public function monthlyReportRestaurant(Request $request)
    {
        // Récupérer le mois sélectionné ou le mois actuel
        $selectedMonth = $request->input('month') ? Carbon::createFromFormat('Y-m', $request->input('month')) : now();

        // Requête pour récupérer les informations des restaurants et des plats commandés
            $restaurants = \DB::table('restaurants')
            ->join('items', 'restaurants.id', '=', 'items.restaurant_id')
            ->join('menu_items', 'items.id', '=', 'menu_items.item_id')
            ->join('order_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'restaurants.id as restaurant_id',
                'restaurants.title as restaurant_name',
                'items.title as item_title',
                'menu_items.price as unit_price',
                \DB::raw('SUM(order_items.quantity) as total_quantity'),
                \DB::raw('SUM(order_items.quantity * menu_items.price) as total_price')
            )
            ->whereYear('orders.created_at', $selectedMonth->year)
            ->whereMonth('orders.created_at', $selectedMonth->month)
            ->groupBy('restaurants.id', 'items.id', 'restaurants.title', 'items.title', 'menu_items.price')
            ->get();


        // Calculer le total par restaurant
        $restaurantData = [];
        foreach ($restaurants as $record) {
            if (!isset($restaurantData[$record->restaurant_id])) {
                $restaurantData[$record->restaurant_id] = [
                    'restaurant_name' => $record->restaurant_name,
                    'total_amount' => 0,
                    'items' => []
                ];
            }
            $restaurantData[$record->restaurant_id]['total_amount'] += $record->total_price;
            $restaurantData[$record->restaurant_id]['items'][] = [
                'title' => $record->item_title,
                'unit_price' => $record->unit_price,
                'total_quantity' => $record->total_quantity,
                'total_price' => $record->total_price
            ];
        }

        return view('admin.reports.monthlyRestaurant', compact('restaurantData', 'selectedMonth'));
    }


}
