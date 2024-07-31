<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('admin.restaurants.index', compact('restaurants'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('admin.restaurants.create');
    }

    // Enregistre un nouveau restaurant
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'website_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        $restaurant = new Restaurant($request->all());
        if ($request->hasFile('logo')) {
            $restaurant->logo = $request->file('logo')->store('logos', 'public');
        }
        $restaurant->save();

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant crée avec succé..');
    }

    // Affiche le formulaire de modification
    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    // Met à jour un restaurant
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'website_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        $restaurant = Restaurant::findOrFail($id);
        $restaurant->fill($request->all());
        if ($request->hasFile('logo')) {
            $restaurant->logo = $request->file('logo')->store('logos', 'public');
        }
        $restaurant->save();

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant modifié avec succé.');
    }

    // Supprime un restaurant
    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        // Supprimer les menu_items associés aux items du restaurant
        foreach ($restaurant->items as $item) {
            $item->menuItems()->delete();
        }
        // Supprimer tous les items associés
        $restaurant->items()->delete();

        // Maintenant, supprimer le restaurant
        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant supprimé avec succé..');
    }

    public function deactivate($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->active = false;
        $restaurant->save();

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant désactivé avec succès.');
    }

    public function activate($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->active = true;
        $restaurant->save();

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant activé avec succès.');
    }

    public function getItems(Restaurant $restaurant)
    {
        return response()->json($restaurant->items);
    }


}
