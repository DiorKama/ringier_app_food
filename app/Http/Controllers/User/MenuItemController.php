<?php
namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use App\Http\Controllers\Controller;

class MenuItemController extends Controller
{
    public function showMenuItems($menu_id)
    { 
        $today = Carbon::today();
        $menu = Menu::where('id', $menu_id)
                    ->where('active', 1)
                    ->whereDate('created_at', $today) 
                    ->firstOrFail();
        $menuItems = MenuItem::where('menu_id', $menu->id)->get();
        return view('user.menu_items.index', compact('menu', 'menuItems'));
    }


    public function addToOrder($menu_item_id)
        {
            $user = auth()->user();

            $order = Order::where('user_id', $user->id)
                        ->where('payment_status', 'pending')
                        ->first();

            if (!$order) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'order_number' => uniqid(),
                    'price' => 0,
                    'payment_status' => 0
                ]);
            }

            $menuItem = MenuItem::findOrFail($menu_item_id);

            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $menuItem->id,
                'unit_price' => $menuItem->price,
                'quantity' => 1
            ]);

            $order->price += $menuItem->price;
            $order->save();

            // Si AJAX, renvoyer une réponse JSON avec les données mises à jour
            if (request()->ajax()) {
                return response()->json([
                    'message' => 'Commande ajouté au panier.',
                    'cart_count' => $order->items->count(), // Nombre d'items dans le panier
                    'order_total' => $order->price // Total de la commande
                ]);
            }
        }


}
