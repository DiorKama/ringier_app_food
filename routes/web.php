<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ItemCategorieController;
use App\Http\Controllers\User\PaymentController;


Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
});

   Route::get('/dashboard', function () {
      return view('dashboard');})->middleware(['auth', 'verified'])->name('dashboard');
 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/mon-profil', [ProfileController::class, 'editUser'])->name('profile.editUser');
    Route::patch('/mon-profil', [ProfileController::class, 'updateUser'])->name('profile.updateUser');
});

// Route::middleware(['auth', 'role:user'])->group(function () {
//     Route::get('user/menu/{menu_id}/items', [App\Http\Controllers\User\MenuItemController::class, 'showMenuItems'])->name('user.menu_items.index');
// });

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::post('/user/order/add/{menu_item_id}', [App\Http\Controllers\User\OrderController::class, 'addToOrder'])->name('order.add');
    Route::get('/user/orders/today', [App\Http\Controllers\User\OrderController::class, 'getOrdersToday'])->name('user.orders.today');
    Route::get('/user/monthlyInvoice', [App\Http\Controllers\User\OrderController::class, 'monthlyInvoice'])->name('user.monthlyInvoice');
    Route::post('/user/pay', [App\Http\Controllers\User\PaymentController::class, 'pay'])->name('user.pay');
    Route::get('/payment/success', [App\Http\Controllers\User\PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/error', [App\Http\Controllers\User\PaymentController::class, 'paymentError'])->name('payment.error');
});

Route::post('payment/notification/wave', [App\Http\Controllers\User\PaymentController::class, 'notification'])->name('payment.notification');

Route::middleware(['auth', 'role:user'])->group(function () {
  Route::get('/user/orders', [App\Http\Controllers\User\OrderItemController::class, 'listingOrderMonth'])->name('user.order_items.listingOrderMonth');
  Route::get('/user/orders/{order}/show', [App\Http\Controllers\User\OrderItemController::class, 'showMonth'])->name('user.orders.show');
});

// Route pour afficher le contenu du panier dans le modal
Route::middleware(['auth', 'role:user'])->group(function () {
   Route::get('/user/cart/modal-content', [App\Http\Controllers\User\OrderController::class, 'modalContent'])->name('user.cart.modal-content');
   Route::get('/checkout', [App\Http\Controllers\User\OrderController::class, 'checkout'])->name('user.order.checkout');
   Route::delete('/order/remove-item/{id}', [App\Http\Controllers\User\OrderController::class, 'removeItem'])->name('user.order.removeItem');

});


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
    Route::post('/users/{id}/adjust-subvention', [AdminController::class, 'adjustSubvention'])->name('admin.users.adjustSubvention');
    Route::post('/users/{id}/adjust-livraison', [AdminController::class, 'adjustLivraison'])->name('admin.users.adjustLivraison');
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
    Route::get('/menus/today', [MenuController::class, 'showMenuOfTheDay'])->name('menus.showMenuOfTheDay');
    Route::get('/admin/menus/create', [MenuController::class, 'create'])->name('admin.menus.create');
    Route::post('/admin/menus', [MenuController::class, 'store'])->name('admin.menus.store');
    Route::get('/admin/menus/{menu}/edit', [MenuController::class, 'edit'])->name('admin.menus.edit');
    Route::put('/admin/menus/{menu}', [MenuController::class, 'update'])->name('admin.menus.update');
    Route::delete('/admin/menus/{menu}', [MenuController::class, 'destroy'])->name('admin.menus.destroy');
    Route::post('/admin/menus/{menu}/activate', [MenuController::class, 'activate'])->name('admin.menus.activate');
    Route::post('/admin/menus/{menu}/deactivate', [MenuController::class, 'deactivate'])->name('admin.menus.deactivate');
    Route::post('/admin/menu/publish', [MenuController::class, 'publish'])->name('admin.menu.publish');

});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/menuItems', [MenuItemController::class, 'index'])->name('admin.menu_items.index');
    Route::get('/admin/menuItems/create', [MenuItemController::class, 'create'])->name('admin.menu_items.create');
    Route::post('/admin/menuItems', [MenuItemController::class, 'store'])->name('admin.menu_items.store');
    Route::get('/admin/menuItems/{menuItem}/edit', [MenuItemController::class, 'edit'])->name('admin.menu_items.edit');
    Route::put('/admin/menuItems/{menuItem}', [MenuItemController::class, 'update'])->name('admin.menu_items.update');
    Route::delete('/admin/menuItems/{menuItem}', [MenuItemController::class, 'destroy'])->name('admin.menu_items.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/today', [OrderController::class, 'showOrderOfTheDay'])->name('orders.showOrderOfTheDay');
    Route::get('/admin/orderItems/today', [OrderItemController::class, 'index'])->name('admin.order_items.index');
    Route::get('/admin/orderItems', [OrderItemController::class, 'listingOrders'])->name('admin.order_items.listingOrder');
    Route::get('/admin/orderItems/create/{menu_item_id}', [OrderItemController::class, 'create'])->name('admin.order_items.create');
    Route::post('/admin/orderItems', [OrderItemController::class, 'store'])->name('admin.order_items.store');
    Route::get('/admin/orderItems/{orderItem}/edit', [OrderItemController::class, 'edit'])->name('admin.order_items.edit');
    Route::put('/admin/orderItems/{orderItem}', [OrderItemController::class, 'update'])->name('admin.order_items.update');
    Route::get('/admin/orderItems/{orderItem}/show',  [OrderItemController::class, 'show'])->name('admin.order_items.show');
    Route::delete('/admin/orderItems/{oderItem}', [OrderItemController::class, 'destroy'])->name('admin.order_items.destroy');
    Route::get('/admin/reports/monthly', [OrderController::class, 'monthlyReport'])->name('admin.reports.monthly');
    Route::get('/admin/reportRestaurants/monthly', [OrderController::class, 'monthlyReportRestaurant'])->name('admin.reportRestaurants.monthly');
    Route::get('/admin/orders/{user_id}/{month}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/admin/orders/pay', [OrderController::class, 'pay'])->name('admin.orders.pay');


});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::get('/settings/edit/{setting}', [SettingController::class, 'edit'])->name('admin.settings.edit');
    Route::put('/settings/update/{setting}', [SettingController::class, 'update'])->name('admin.settings.update');
});


require __DIR__.'/auth.php';

