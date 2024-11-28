<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Menu;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuItemController extends Controller
{
    public function index()
    {
        // Obtenez le menu du jour
        $menu = Menu::getOfMenuOfTheDay();

        // Vérifiez si le menu du jour contient des items
        $menuItems = MenuItem::where('menu_id', $menu->id)->with('items.restaurants')->get();

        

        return view('admin.menu_items.index', compact('menuItems', 'menu'));
    }

    public function create(MenuItem $menuItems)
    {
        
        $menu = Menu::getOfMenuOfTheDay();

        $items = Item::all();
        $restaurants = Restaurant::all();
        return view('admin.menu_items.create', compact('menuItems','menu', 'items', 'restaurants'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'item_id' => 'required|exists:items,id',
            'price' => 'required|integer|min:0',
        ]);

        $validatedData['user_id'] = Auth::id();

        MenuItem::create($validatedData);

        return redirect()->route('admin.menu_items.index')->with('success', 'Menu Item created successfully.');
    }

    public function edit(MenuItem $menuItem)
    {
        $menus = Menu::all();
        $items = Item::all();
        $restaurants = Restaurant::all();
        return view('admin.menu_items.edit', compact('menuItem', 'menus', 'items', 'restaurants'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'item_id' => 'required|exists:items,id',
            'price' => 'required|integer|min:0',
        ]);

        $validatedData = $request->all();
        $validatedData['user_id'] = Auth::id();

        $menuItem->update($validatedData);

        return redirect()->route('admin.menu_items.index')->with('success', 'Menu Item updated successfully.');
    }

    public function destroy(MenuItem $menuItem)
    {
        // Supprimer tous les orderItems associés à cet menuItems
        $menuItem->orderItems()->delete();
        // Suppression du MenuItem
        $menuItem->delete();
        return redirect()->route('admin.menu_items.index')->with('success', 'Menu Item deleted successfully.');
    }  
    
    
}





