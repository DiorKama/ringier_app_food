<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() 
    {
        $today = Carbon::today();

        // Chercher le menu du jour
        $menu = Menu::where('active', 1)
                    ->whereDate('created_at', $today)
                    ->whereNotNull('validated_date')
                    ->first();

        // Si un menu est trouvé, récupérer les items associés
        $menuItems = $menu ? MenuItem::where('menu_id', $menu->id)->get() : collect();

        // Calculer le temps restant en secondes
        $remainingSeconds = $menu && $menu->closing_date ? Carbon::parse($menu->closing_date)->diffInSeconds(now()) : 0;

        return view('user.dashboard', [
            'menu' => $menu,
            'menuItems' => $menuItems,
            'remainingSeconds' => $remainingSeconds,
        ]);
    }




}
