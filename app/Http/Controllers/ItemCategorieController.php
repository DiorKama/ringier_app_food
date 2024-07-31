<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ItemCategorie;

class ItemCategorieController extends Controller
{
    public function index()
    {
        $categories = ItemCategorie::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = ItemCategorie::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:item_categories,id',
            'active' => 'boolean',
        ]);

        ItemCategorie::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'active' => $request->active,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category créée avec succé.');
    }

    public function edit($id)
    {
        $category = ItemCategorie::findOrFail($id);
        $parentCategories = ItemCategorie::whereNull('parent_id')->where('id', '!=', $id)->get();
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:item_categories,id',
            'active' => 'boolean',
        ]);

        $category = ItemCategorie::findOrFail($id);
        $category->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'active' => $request->active,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category modifié avec succé.');
    }

    public function destroy($id)
    {
        $category = ItemCategorie::findOrFail($id);
        
        // Supprimer tous les menu_items associés aux items de cette catégorie
        foreach ($category->items as $item) {
            $item->menuItems()->delete();
        }
        // Supprimer tous les items associés
        $category->items()->delete();

        // Maintenant, supprimer la catégorie
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category supprimé avec succé.');
    }


    public function deactivate($id)
    {
        $category = ItemCategorie::findOrFail($id);
        $category->active = false;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category a été déséctivé avec succé.');
    }

    public function activate($id)
    {
        $category = ItemCategorie::findOrFail($id);
        $category->active = true;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category activé avec succès.');
    }

}
