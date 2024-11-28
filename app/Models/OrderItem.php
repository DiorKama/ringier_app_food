<?php

namespace App\Models;

use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function menuItems()
    {
        return $this->belongsTo(MenuItem::class, 'menu_item_id');
    }

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }




}
