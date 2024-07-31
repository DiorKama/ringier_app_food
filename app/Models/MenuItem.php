<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function menus() {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function items() {
        return $this->belongsTo(Item::class, 'item_id');
    }

}
