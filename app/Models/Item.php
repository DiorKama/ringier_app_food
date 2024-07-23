<?php

namespace App\Models;

use App\Models\ItemCategorie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function categories() {
        return $this->belongsTo(ItemCategorie::class, 'item_category_id');
    }
    public function restaurants() {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}
