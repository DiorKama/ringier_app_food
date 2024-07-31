<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuItemController extends Controller
{
    
    public function index()
    {
        $menuItems = MenuItem::with('items.restaurants')->get(); // Charger les relations
        return view('admin.menu_items.index', compact('menuItems'));
    }

    public function create()
    {
        $menus = Menu::all();
        $items = Item::all();
        $restaurants = Restaurant::all(); // Récupérer tous les restaurants
        $defaultMenuId = 1;

        return view('admin.menu_items.create', compact('menus', 'items', 'restaurants', 'defaultMenuId'));
    }

    public function store(Request $request)
    {
        // Valider les données de la requête
        $validatedData = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'item_id' => 'required|exists:items,id',
            'price' => 'required|integer|min:0',
        ]);

        // Ajout de l'user_id à partir de l'utilisateur authentifié
        $validatedData['user_id'] = Auth::id();


        // Création de l'entrée dans menu_items
        MenuItem::create($validatedData);

        return redirect()->route('admin.menu_items.index')->with('success', 'Menu Item created successfully.');
    }

    public function edit(MenuItem $menuItem)
    {
        $menus = Menu::all();
        $items = Item::all();
        $restaurants = Restaurant::all();
        $defaultMenuId = 1;
        return view('admin.menu_items.edit', compact('menuItem', 'menus', 'items', 'restaurants', 'defaultMenuId'));
    }


    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'item_id' => 'required|exists:items,id',
            'price' => 'required|integer|min:0',
        ]);

        // Ajout de l'user_id à partir de l'utilisateur authentifié
        $validatedData = $request->all();
        $validatedData['user_id'] = Auth::id();

        // Mise à jour de l'entrée dans menu_items
        $menuItem->update($validatedData);

        return redirect()->route('admin.menu_items.index')->with('success', 'Menu Item updated successfully.');
    }


    public function destroy(MenuItem $menuItem)
    {
        // Suppression des relations si nécessaire
        // $menuItem->items()->delete(); // Assurez-vous que cette relation est correctement définie

        // Suppression du MenuItem
        $menuItem->delete();

        return redirect()->route('admin.menu_items.index')->with('success', 'Menu Item deleted successfully.');
    }

}

