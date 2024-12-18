<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminAuth\RegisterController;
use App\Http\Controllers\AdminAuth\LoginController;
use App\Http\Controllers\AdminDashboardController; 
use App\Http\Controllers\ShopController; // Ensure this controller exists
use App\Http\Controllers\AdminAuth\UserDashboardController; // Import the UserDashboardController
use App\Http\Controllers\UserAuth\CartController; // Add CartController import
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CheckoutController;  // Add CheckoutController import
use App\Http\Controllers\OrderController;


/*
|-------------------------------------------------------------------------- 
| Web Routes 
|-------------------------------------------------------------------------- 
| 
| Here is where you can register web routes for your application. These 
| routes are loaded by the RouteServiceProvider and all of them will 
| be assigned to the "web" middleware group. Make something great! 
| 
*/

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route for authenticated users
Route::get('/dashboard', [UserDashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Registration routes
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    
    // Login routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    
    // Logout route
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Product routes for admins, protected by the auth:admin middleware
    Route::middleware('auth:admin')->group(function() {
    Route::resource('products', \App\Http\Controllers\AdminAuth\ProductController::class);
    });
});

// Admin dashboard route protected by the admin middleware
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// User dashboard route for authenticated users
Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard')->middleware(['auth', 'verified']);
Route::get('/products', [UserDashboardController::class, 'show'])->name('products.show');
// Cart routes for adding, viewing, and removing items in the cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('add/{id}', [CartController::class, 'addToCart'])->name('add');
    Route::get('', [CartController::class, 'viewCart'])->name('view');
    Route::delete('delete/{id}', [CartController::class, 'removeFromCart'])->name('delete');
    
  


});
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});
// routes/web.php
Route::get('/admin/reports', [AdminDashboardController::class, 'showMostBoughtProducts'])->name('admin.reports');

Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
Route::get('/favorites/index', [FavoriteController::class, 'index'])->name('favoritesindex');
Route::post('favorite/remove', [FavoriteController::class, 'remove'])->name('favorite.remove');
Route::post('/favorite/remove', [FavoriteController::class, 'removeFromFavorites'])->name('favorite.remove');

Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');

// Change this in your routes/web.php

Route::post('checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::post('/checkout/confirm', [CheckoutController::class, 'confirmOrder'])->name('order.confirm');
Route::get('/order/confirmation/{order}', [CheckoutController::class, 'orderConfirmation'])->name('order.confirmation');
Route::get('/orders', [CheckoutController::class, 'showOrders'])->name('Order_List');

Route::post('/checkout/confirm-order', [CheckoutController::class, 'confirmOrder'])->name('checkout.confirmOrder');


// routes/web.php

Route::get('/admin/orders', [AdminDashboardController::class, 'viewOrders'])->name('admin.allOrders.index');


Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('admin/orders', [AdminDashboardController::class, 'viewOrders'])->name('admin.allOrders');

Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

Route::post('/cart/remove-all', [CartController::class, 'removeAll'])->name('cart.removeAll');
// routes/web.php
Route::get('/checkout/success', [CheckoutController::class, 'confirmation'])->name('checkout.success');



Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');


Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');


Route::get('/admin/most-sold-product', [AdminDashboardController::class, 'mostSoldProduct'])->name('admin.mostSoldProduct');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

Route::get('/admin/dashboard/allorders', [AdminDashboardController::class, 'modaldashboard'])->name('admin.allorders');



require __DIR__.'/auth.php';
