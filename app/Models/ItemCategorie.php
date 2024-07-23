<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemCategorie extends Model
{
    use HasFactory;
     

    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}