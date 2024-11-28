<?php

namespace App\Models;

use App\Models\User;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function menuItems(){
        return $this->hasMany(MenuItem::class);
    }

    // ScopeActive
    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }
    //ScopeInactive
    public function scopeInactive(Builder $query): void
    {
        $query->where('active', 0);
    }

    //ScopeMenuOfTheDay
    public function scopeMenuOfTheDay(Builder $query): Builder 
    {
        $currentDate = now()->startOfDay();
        return $query->whereDate('created_at', $currentDate);
    }
    
    public static function getOfMenuOfTheDay()
    {
        $currentDate = now()->startOfDay();
        
        // Recherche du menu du jour
        $menu = self::menuOfTheDay()->first();
        
        // Si aucun menu n'existe, on le crée
        if (!$menu) {
            $menu = self::create([
                'title' => 'Menu du jour ' . $currentDate->format('d/m/Y'),
                'user_id' => Auth::id(),
                'validated_date' => null,
                'closing_date' => null,
                'active' => false,
            ]);
        }

        
        
        return $menu;
    }


}
