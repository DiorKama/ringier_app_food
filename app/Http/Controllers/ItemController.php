<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ItemCategorie;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with(['restaurants', 'categories'])->get();
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        $restaurants = Restaurant::all();
        $categories = ItemCategorie::all();
        return view('admin.items.create', compact('restaurants', 'categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'restaurant_id' => 'required|exists:restaurants,id',
            'item_category_id' => 'required|exists:item_categories,id',
            'item_thumb' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|integer|min:0',
        ]);

        $imageName = time().'.'.$request->item_thumb->extension();
        $request->item_thumb->move(public_path('images'), $imageName);

        $validatedData['slug'] = Str::slug($validatedData['title']);
        $validatedData['item_thumb'] = 'images/'.$imageName;

        Item::create($validatedData);

        return redirect()->route('admin.items.index')->with('success', 'Plat créé avec succé.');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $restaurants = Restaurant::all();
        $categories = ItemCategorie::all();
        return view('admin.items.edit', compact('item', 'restaurants', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'restaurant_id' => 'required|exists:restaurants,id',
            'item_category_id' => 'required|exists:item_categories,id',
            'item_thumb' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('item_thumb')) {
            $imageName = time().'.'.$request->item_thumb->extension();
            $request->item_thumb->move(public_path('images'), $imageName);
            $validatedData['item_thumb'] = 'images/'.$imageName;
        }

        $validatedData['slug'] = Str::slug($validatedData['title']);

        $item->update($validatedData);

        return redirect()->route('admin.items.index')->with('success', 'Plats modifiés avec succé.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'Plats supprimés avec succé.');
    }

    public function deactivate($id)
    {
        $item = Item::findOrFail($id);
        $item->update(['active' => 0]);

        return redirect()->route('admin.items.index')->with('success', 'Plats désactivés avec succé.');
    }

    public function activate($id)
    {
        $item = Item::findOrFail($id);
        $item->update(['active' => 1]);

        return redirect()->route('admin.items.index')->with('success', 'Plats activés avec succé.');
    }
}