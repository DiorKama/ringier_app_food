<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ItemCategorieController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect(RouteServiceProvider::home());
})->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'listUsers'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class, 'createUserForm'])->name('admin.users.create');
    Route::post('/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::post('/users/{id}/make-admin', [AdminController::class, 'makeAdmin'])->name('admin.users.makeAdmin');
    Route::post('/users/{id}/revoke-admin', [AdminController::class, 'revokeAdmin'])->name('admin.users.revokeAdmin');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUserForm'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/restaurants', [RestaurantController::class, 'index'])->name('admin.restaurants.index');
    Route::get('/admin/restaurants/create', [RestaurantController::class, 'create'])->name('admin.restaurants.create');
    Route::post('/admin/restaurants', [RestaurantController::class, 'store'])->name('admin.restaurants.store');
    Route::get('/admin/restaurants/{id}/edit', [RestaurantController::class, 'edit'])->name('admin.restaurants.edit');
    Route::put('/admin/restaurants/{id}', [RestaurantController::class, 'update'])->name('admin.restaurants.update');
    Route::delete('/admin/restaurants/{id}', [RestaurantController::class, 'destroy'])->name('admin.restaurants.destroy');
    Route::post('/admin/restaurants/{id}/deactivate', [RestaurantController::class, 'deactivate'])->name('admin.restaurants.deactivate');
    Route::post('/admin/restaurants/{id}/activate', [RestaurantController::class, 'activate'])->name('admin.restaurants.activate');
    Route::get('/api/restaurants/{restaurant}/items', [RestaurantController::class, 'getItems']);


});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/categories', [ItemCategorieController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [ItemCategorieController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [ItemCategorieController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{id}/edit', [ItemCategorieController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{id}', [ItemCategorieController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}', [ItemCategorieController::class, 'destroy'])->name('admin.categories.destroy');
    Route::post('/admin/categories/{id}/deactivate', [ItemCategorieController::class, 'deactivate'])->name('admin.categories.deactivate');
    Route::post('/admin/categories/{id}/activate', [ItemCategorieController::class, 'activate'])->name('admin.categories.activate');

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/items', [ItemController::class, 'index'])->name('admin.items.index');
    Route::get('/admin/items/create', [ItemController::class, 'create'])->name('admin.items.create');
    Route::post('/admin/items', [ItemController::class, 'store'])->name('admin.items.store');
    Route::get('/admin/items/{id}/edit', [ItemController::class, 'edit'])->name('admin.items.edit');
    Route::put('/admin/items/{item}', [ItemController::class, 'update'])->name('admin.items.update');
    Route::delete('/admin/items/{id}', [ItemController::class, 'destroy'])->name('admin.items.destroy');
    Route::post('/admin/items/{id}/deactivate', [ItemController::class, 'deactivate'])->name('admin.items.deactivate');
    Route::post('/admin/items/{id}/activate', [ItemController::class, 'activate'])->name('admin.items.activate');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/menus', [MenuController::class, 'index'])->name('admin.menus.index');
    Route::get('/admin/menus/create', [MenuController::class, 'create'])->name('admin.menus.create');
    Route::post('/admin/menus', [MenuController::class, 'store'])->name('admin.menus.store');
    Route::get('/admin/menus/{menu}/edit', [MenuController::class, 'edit'])->name('admin.menus.edit');
    Route::put('/admin/menus/{menu}', [MenuController::class, 'update'])->name('admin.menus.update');
    Route::delete('/admin/menus/{menu}', [MenuController::class, 'destroy'])->name('admin.menus.destroy');
    Route::post('/admin/menus/{menu}/activate', [MenuController::class, 'activate'])->name('admin.menus.activate');
    Route::post('/admin/menus/{menu}/deactivate', [MenuController::class, 'deactivate'])->name('admin.menus.deactivate');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/menuItems', [MenuItemController::class, 'index'])->name('admin.menu_items.index');
    Route::get('/admin/menuItems/create', [MenuItemController::class, 'create'])->name('admin.menu_items.create');
    Route::post('/admin/menuItems', [MenuItemController::class, 'store'])->name('admin.menu_items.store');
    Route::get('/admin/menuItems/{menuItem}/edit', [MenuItemController::class, 'edit'])->name('admin.menu_items.edit');
    Route::put('/admin/menuItems/{menuItem}', [MenuItemController::class, 'update'])->name('admin.menu_items.update');
    Route::delete('/admin/menuItems/{menuItem}', [MenuItemController::class, 'destroy'])->name('admin.menu_items.destroy');
});



Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
});

require __DIR__.'/auth.php';

