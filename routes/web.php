<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');

Route::get('/cart',[CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('/cart/decrease-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.item.remove');
Route::delete('/cart/clear', [CartController::class, 'empty_cart'])->name('cart.item.clear');

Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/place-an-order', [CartController::class, 'place_an_order'])->name('cart.place.an.order');
Route::get('/order-confirmation', [CartController::class, 'order_confirmation'])->name('cart.order.confirmation');

Route::get('/search', [HomeController::class, 'search'])->name('home.search');

Route::get('/contact-us', [HomeController::class, 'contact'])->name('home.contact');
Route::post('/contact/store', [HomeController::class, 'contact_store'])->name('home.contact.store');

Route::get('/search', [HomeController::class, 'search'])->name('home.search');

Route::post('/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/item/remove/{rowId}', [WishlistController::class, 'remove_item'])->name('wishlist.item.remove');
Route::delete('/wishlist/clear', [WishlistController::class, 'empty_wishlist'])->name('wishlist.item.clear');
Route::post('/wishlist/move-to-cart/{rowid}', [WishlistController::class, 'move_to_cart'])->name('wishlist.move.to.cart');

Route::middleware(['auth'])->group(function () {
    // ini bagian User Show Order and Order Details
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('/account-orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/account-order-details/{order_id}', [UserController::class, 'order_details'])->name('user.order.details');
    Route::put('/account-order-details/cancel-order', [UserController::class, 'order_cancel'])->name('user.order.cancel');
});


Route::middleware(['auth',AuthAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/vendors', [AdminController::class, 'vendors'])->name('admin.vendors');
    Route::get('/admin/vendor/add', [AdminController::class, 'add_vendor'])->name('admin.vendor.add');
    Route::post('/admin/vendor/store', [AdminController::class, 'vendor_store'])->name('admin.vendor.store');
    Route::get('/admin/vendor/edit/{id}', [AdminController::class, 'vendor_edit'])->name('admin.vendor.edit');
    Route::put('/admin/vendor/update/{id}', [AdminController::class, 'vendor_update'])->name('admin.vendor.update');
    Route::delete('/admin/vendor/{id}/delete', [AdminController::class, 'vendor_delete'])->name('admin.vendor.delete');

    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('/admin/category/update/{id}', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/delete/{id}', [AdminController::class, 'category_delete'])->name('admin.category.delete');

    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update/{id}', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::delete('/admin/product/delete/{id}', [AdminController::class, 'product_delete'])->name('admin.product.delete');

    // Ini yang baru ditambahkan bagian 20,41 admin
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/order/details/{id}', [AdminController::class, 'order_details'])->name('admin.order.details');

    Route::get('/admin/contact', [AdminController::class, 'contacts'])->name('admin.contacts');
    Route::delete('/admin/contact/{id}/delete', [AdminController::class, 'contact_delete'])->name('admin.contact.delete');
    //  ini bagian Admin Update Order Status
    Route::put('/admin/order/update-Status/{id}', [AdminController::class, 'update_order_status'])->name('admin.order.status.update');
    
    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
});


