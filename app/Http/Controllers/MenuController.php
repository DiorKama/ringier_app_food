<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
         $menus = Menu::all();
         return view('admin.menus.index', compact('menus'));
    }
    
    public function showMenuOfTheDay()
    {
        $menu = Menu::getOfMenuOfTheDay()->first(); 
        return view('admin.menus.showMenuOfTheDay', ['menu' => $menu]);
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'validated_date' => 'nullable|date',
            'closing_date' => 'nullable|date',
        ]);

        Menu::create($request->all());

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'validated_date' => 'nullable|date',
            'closing_date' => 'nullable|date',
        ]);

        $menu->update($request->all());

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }

    public function deactivate(Menu $menu)
    {
        $menu->active = false;
        $menu->save();

        return redirect()->route('admin.menus.index')->with('success', 'Menu deactivated successfully.');
    }

    public function activate(Menu $menu)
    {
        $menu->active = true;
        $menu->save();

        return redirect()->route('admin.menus.index')->with('success', 'Menu activated successfully.');
    }


    // Fonction pour publier le menu
    public function publish(Request $request)
    {   
        $menu = Menu::findOrFail($request->menu_id);

        // Mettre à jour le statut du menu à 'actif'
        $menu->active = 1;
        $menu->validated_date = now(); // Optionnel : définir la date de validation
        $menu->closing_date = now()->addMinutes(30);
        $menu->save();

        // Rediriger avec un message de succès
        return redirect()->route('admin.menu_items.index')->with('success', 'Le menu a été publié avec succès.');
    }

}


