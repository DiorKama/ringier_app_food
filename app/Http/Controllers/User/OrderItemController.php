<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class OrderItemController extends Controller{


    public function listingOrderMonth(Request $request)
    {
        // Récupérer l'utilisateur authentifié
        $userId = auth()->id();

        // Récupérer le mois sélectionné ou le mois actuel si aucun n'est fourni
        $selectedMonth = $request->input('month', now()->format('m'));
        $selectedYear = $request->input('year', now()->format('Y'));

        // Filtrer les commandes par mois et par utilisateur
        $orders = OrderItem::select('orders.order_number', 'order_items.created_at', 'order_items.order_id')
            ->selectRaw('MIN(order_items.id) as id, SUM(order_items.quantity * order_items.unit_price) as total_price')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('order_items.created_at', $selectedYear)
            ->whereMonth('order_items.created_at', $selectedMonth)
            ->where('orders.user_id', $userId) // Filtre par utilisateur
            ->groupBy('orders.order_number', 'order_items.created_at', 'order_items.order_id')
            ->orderBy('order_items.created_at', 'desc')
            ->get();

        return view('user.order_items.listingOrderMonth', compact('orders', 'selectedMonth', 'selectedYear'));
    }


}