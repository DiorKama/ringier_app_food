<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menus.index', compact('menus'));
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
}


