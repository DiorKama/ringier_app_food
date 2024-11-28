<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{

    public function listingOrders()
    {
        $orders = OrderItem::select('orders.order_number', 'order_items.created_at', 'order_items.order_id')
            ->selectRaw('MIN(order_items.id) as id, SUM(order_items.quantity * order_items.unit_price) as total_price') // Inclure l'ID et calculer le prix total
            ->join('orders', 'order_items.order_id', '=', 'orders.id') // Jointure avec la table orders
            ->groupBy('orders.order_number', 'order_items.created_at', 'order_items.order_id')
            ->orderBy('order_items.created_at', 'desc')
            ->get();

        return view('admin.order_items.listingOrder', compact('orders'));
    }


    public function index(Request $request)
{
    // Récupérer les commandes du jour avec les utilisateurs et les items de menu
    $orders = Order::with(['user', 'orderItems.menuItems.items.restaurants'])
        ->whereDate('created_at', now()->toDateString())  // Filtrer les commandes du jour
        ->get();

    // Grouper les commandes par utilisateur et cumuler les quantités pour chaque article
    $userOrders = $orders->groupBy('user.id')->map(function ($userOrders) {
        $user = $userOrders->first()->user;
        $items = $userOrders->flatMap(function ($order) {
            return $order->orderItems->map(function ($orderItem) {
                return [
                    'restaurant' => $orderItem->menuItems->items->restaurants->title,
                    'item' => $orderItem->menuItems->items->title,
                    'quantity' => $orderItem->quantity,
                ];
            });
        })->groupBy('restaurant')->map(function ($items) {
            return $items->groupBy('item')->map(function ($groupedItems) {
                return [
                    'item' => $groupedItems->first()['item'],
                    'quantity' => $groupedItems->sum('quantity')
                ];
            });
        });

        return [
            'user' => $user,
            'items' => $items
        ];
    });

    // Grouper les commandes par restaurant et cumuler les quantités pour chaque article
    $restaurantOrders = $orders->flatMap(function ($order) {
        return $order->orderItems->map(function ($orderItem) {
            return [
                'restaurant' => $orderItem->menuItems->items->restaurants->title,
                'item' => $orderItem->menuItems->items->title,
                'quantity' => $orderItem->quantity,
            ];
        });
    })->groupBy('restaurant')->map(function ($items) {
        return $items->groupBy('item')->map(function ($groupedItems) {
            return [
                'item' => $groupedItems->first()['item'],
                'quantity' => $groupedItems->sum('quantity')
            ];
        });
    });

    // Vérifier si c'est une requête AJAX
    if ($request->ajax()) {
        return response()->json([
            'orders' => $orders,
            'userOrders' => $userOrders,
            'restaurantOrders' => $restaurantOrders
        ]);
    }

    // Sinon, afficher la vue normale
    return view('admin.order_items.index', compact('orders', 'userOrders', 'restaurantOrders'));
}





    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        // Trouver le MenuItem correspondant à l'ID passé
        $menuItem = MenuItem::findOrFail($request->menu_item_id);

        // Récupérer tous les restaurants (si nécessaire)
        $restaurants = Restaurant::all();

        // Créer une instance vide d'OrderItem avec une quantité par défaut
        $orderItem = new OrderItem([
            'menuItem_id' => $menuItem->id,
            'unit_price' => $menuItem->price,
            'quantity' => 1, // Quantité par défaut
        ]);

        return view('admin.order_items.create', compact('orderItem', 'menuItem', 'restaurants'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
        {
            // Valider les données de la requête
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'menu_item_id' => 'required|exists:menu_items,id',
                'quantity' => 'required|integer|min:1',
                'unit_price' => 'required|numeric|min:0',
            ]);

            // Trouver l'utilisateur
            $user = User::findOrFail($request->input('user_id'));

            //dd($user->id);

            // Récupérer ou créer la commande du jour
            $todayUserOrder = $user->getOrderOfTheDay();

            //dd($todayUserOrder);

            // Vérifier l'item existant ou ajouter un nouvel item
            $existingOrderItem = OrderItem::where('order_id', $todayUserOrder->id)
                ->where('menu_item_id', $request->input('menu_item_id'))
                ->first();

            if ($existingOrderItem) {
                $existingOrderItem->quantity += $request->input('quantity');
                $existingOrderItem->save();
            } else {
                OrderItem::create([
                    'order_id' => $todayUserOrder->id,
                    'menu_item_id' => $request->input('menu_item_id'),
                    'unit_price' => $request->input('unit_price'),
                    'quantity' => $request->input('quantity'),
                ]);
            }

            // Mettre à jour le prix total
            $totalPrice = OrderItem::where('order_id', $todayUserOrder->id)->sum(DB::raw('quantity * unit_price'));
            $todayUserOrder->price = $totalPrice;
            $todayUserOrder->save();

            // Récupérer le nombre d'items dans la commande pour cet utilisateur
            $cartCount = $todayUserOrder->items->count();

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Commande ajoutée avec succès.',
                    'cart_count' => $cartCount,
                    'order_total' => $todayUserOrder->price,
                ]);
            }
        
            // Sinon, rediriger vers la page des commandes
            return redirect()->route('admin.menu_items.index')->with('success', 'Commande ajoutée avec succès.');
        }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 
    }
}
