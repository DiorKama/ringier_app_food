<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    //ScopeOrderOfTheDay
    public function scopeOrderOfTheDay(Builder $query): Builder 
    {
        $currentDate = now()->startOfDay();
        return $query
            ->whereDate('created_at', $currentDate);
    }
    
    // Order.php
    public static function getOrderOfTheDay($userId)
    {
        $currentDate = now()->startOfDay();

        // Récupérer la commande du jour pour l'utilisateur spécifié
        $order = self::where('user_id', $userId)
                    ->whereDate('created_at', $currentDate)
                    ->first();

        if (!$order) {
            // Créer une nouvelle commande si elle n'existe pas
            $order = self::create([
                'user_id' => $userId,
                'order_number' => 'ED_' . uniqid(),
                'price' => 0,
                'payment_status' => 0,
            ]);
        }
        return $order;
    }

//Order.php
    protected function getMonthlyOrdersForUser($userId, $month)
    {
    return Order::with(['orderItems.menuItems.items.restaurants'])
    ->where('user_id', $userId)
    ->whereMonth('created_at', '=', Carbon::parse($month)->month)
    ->whereYear('created_at', '=', Carbon::parse($month)->year)
    ->get()
    ->flatMap(function ($order) {
        // Associer chaque orderItem à son restaurant
        return $order->orderItems->map(function ($orderItem) use ($order) {
            $restaurant = optional($orderItem->menuItems->items->restaurants);
            return [
                'restaurant_id' => $restaurant ? $restaurant->id : null,
                'restaurant_name' => $restaurant ? $restaurant->title : 'Aucun restaurant',
                'price' => $order->price,
                'order_item' => [
                    'title' => optional($orderItem->menuItems->items)->title,
                    'unit_price' => $orderItem->unit_price,
                    'quantity' => $orderItem->quantity,
                    'total_price' => $orderItem->quantity * $orderItem->unit_price,
                ],
            ];
            });
        })
        ->groupBy('restaurant_id')
        ->map(function ($groupedItems, $restaurantId) {
            $restaurantName = $groupedItems->first()['restaurant_name'];
            
            // Calcul du total pour les items de ce restaurant uniquement
            $totalAmount = $groupedItems->sum(function ($item) {
                return $item['order_item']['total_price'];
            });
        
            return [
                'restaurant_name' => $restaurantName,
                'total_amount' => $totalAmount,
                'items' => $groupedItems->groupBy(function ($item) {
                    return $item['order_item']['title'] . '-' . $item['order_item']['unit_price'];
                })->map(function ($groupedItems) {
                    $firstItem = $groupedItems->first()['order_item'];
                    $totalQuantity = $groupedItems->sum(fn($item) => $item['order_item']['quantity']);
                    return [
                        'title' => $firstItem['title'],
                        'unit_price' => $firstItem['unit_price'],
                        'total_quantity' => $totalQuantity,
                        'total_price' => $firstItem['unit_price'] * $totalQuantity,
                    ];
                })->values()->all(),
            ];
        });
    }
    
   
}
