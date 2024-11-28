<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class OrderController extends Controller{

    public function addToOrder($menu_item_id)
{
    $user = auth()->user();

    // Récupérer la commande d'aujourd'hui pour l'utilisateur
    $order = Order::where('user_id', $user->id)
                  ->whereDate('created_at', today()) // Filtrer par la date d'aujourd'hui
                  ->first();

    // Si aucune commande n'existe, en créer une
    if (!$order) {
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => uniqid(),
            'price' => 0,
            'payment_status' => 0
        ]);
    }

    // Récupérer le MenuItem et vérifier la condition de closing_date du menu associé
    $menuItem = MenuItem::findOrFail($menu_item_id);
    $menu = $menuItem->menus; // Récupérer le menu associé

    // Vérifiez si le Menu est encore disponible (pas clôturé)
    if ($menu->closing_date && $menu->closing_date < now()) {
        return response()->json([
            'message' => 'Temps écoulé! Demander de l\'aide au gestionnaire.',
        ], 400); // 400 Bad Request
    }

    // Ajouter l'item à la commande
    OrderItem::create([
        'order_id' => $order->id,
        'menu_item_id' => $menuItem->id,
        'unit_price' => $menuItem->price,
        'quantity' => 1
    ]);

    // Mettre à jour le prix de la commande
    $order->price += $menuItem->price;
    $order->save();

    // Si AJAX, renvoyer une réponse JSON avec les données mises à jour
    if (request()->ajax()) {
        return response()->json([
            'message' => 'Commande ajoutée au panier.',
            'cart_count' => $order->items->count(), // Nombre d'items dans le panier
            'order_total' => $order->price // Total de la commande
        ]);
    }
}


    // public function modalContent()
    // {
    //     // Utilisation de collect() pour assurer que $cart est une collection, même si vide
    //     $cart = auth()->user()->dailyOrder ? auth()->user()->dailyOrder->items : collect();
    //     dd($cart);
    //     return view('user.cart.modal-content', compact('cart'));
    // }



    
    // public function checkout()
    // {
    //     // Récupérer la commande en cours
    //     $pendingOrder = auth()->user()->pendingOrder;

    //     // Vérifier que la commande n'est pas vide
    //     if (!$pendingOrder || $pendingOrder->items->isEmpty()) {
    //         return redirect()->back()->with('error', 'Votre panier est vide.');
    //     }

    //     // Logique de checkout ici...

    //     return view('user.cart.checkout', compact('pendingOrder'));
    // }


    public function removeItem($id)
    {
        // Trouver l'item de commande à supprimer
        $orderItem = OrderItem::findOrFail($id);
    
        // Récupérer le MenuItem et vérifier la condition de closing_date du menu associé
        $menuItem = $orderItem->menuItems; // Récupérer le MenuItem associé
        $menu = $menuItem->menus; // Récupérer le menu associé
    
        // Vérifiez si le Menu est encore disponible (pas clôturé)
        if ($menu->closing_date && $menu->closing_date < now()) {
            return response()->json(['error' => 'Temps écoulé! Impossible de supprimer ce plat.'], 400);
        }
    
        // Mettre à jour le prix total de la commande
        $order = $orderItem->orders;
        $order->price -= ($orderItem->unit_price * $orderItem->quantity);
        $order->save();
    
        // Supprimer l'article de la commande
        $orderItem->delete();
    
        return response()->json(['success' => 'L\'article a été supprimé du panier.']);
    }
    


    public function getOrdersToday()
    {
        // $user = auth()->user();

        $orders = Order::whereDate('created_at', today())
        ->with(['user','items.menuItems.items.restaurants']) // Charger les relations nécessaires
        ->get();
            
            return response()->json([
                'orders' => $orders->map(function ($order) {
                    return [
                        'order_number' => $order->order_number,
                        'price' => $order->price,
                        'items_count' => $order->items->count(),
                        'user' => [
                                'firstName' => $order->user->firstName, // Ajout de l'utilisateur
                                'lastName' => $order->user->lastName,
                            ],

                        'items' => $order->items->map(function ($item) {
                            return [
                                'menuItems' => [
                                    'items' => [
                                        'restaurants' => [
                                            'title' => $item->menuItems->items->restaurants->title
                                        ],
                                        'title' => $item->menuItems->items->title,
                                    ],
                                ],
                                'quantity' => $item->quantity,
                                'unit_price' => $item->unit_price,
                            ];
                        }),
                    ];
                })
            ]);
    }

    public function monthlyInvoice(Request $request)
    {
        
        // Convertir `$selectedMonth` en objet Carbon
        
        $user = auth()->user();
        // $selectedMonth = Carbon::parse($request->input('month') ?? now()->format('Y-m'))
        
        $selectedMonth = $request->input('month');
        if (!$selectedMonth) {
            $selectedMonth = Carbon::now();
        } else {
            $selectedMonth = Carbon::parse($selectedMonth); 
        }


        // Appel de la méthode dans le modèle Order
        $userData = \App\Models\Order::getMonthlyOrdersForUser($user->id, $selectedMonth);

         // Récupérer les valeurs de subvention et de livraison depuis l'utilisateur
        $subvention = $user->subvention ?? 0; // Subvention par défaut à 0 si non définie
        $deliveryFee = $user->livraison ?? 0; // Livraison par défaut à 0 si non définie

        // Calcul des totaux
        $totalBrut = collect($userData)->sum('total_amount');
        $finalTotal = $totalBrut * (1 - $subvention / 100) + $deliveryFee;



        return view('user.reports.monthly_invoice', compact('userData', 'selectedMonth', 'totalBrut', 'subvention', 'deliveryFee', 'finalTotal'));
    }


    

}