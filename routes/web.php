<?php

use App\Http\Controllers\AllergenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\DineinTableController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/resto/{slug}', [RestaurantController::class, 'show'])->name('restaurants.show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // restaurants
    Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants');
    Route::get('/restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');

    // dinein tables
    Route::get('/dinein-tables', [DineinTableController::class, 'index'])->name('dinein-tables');
    Route::post('/dinein-tables', [DineinTableController::class, 'store'])->name('dinein-tables.store');
    Route::get('/dinein-tables/{dineinTable}/edit', [DineinTableController::class, 'edit'])->name('dinein-tables.edit');
    Route::put('/dinein-tables/{dineinTable}', [DineinTableController::class, 'update'])->name('dinein-tables.update');
    Route::delete('/dinein-tables/{dineinTable}', [DineinTableController::class, 'destroy'])->name('dinein-tables.destroy');

    // categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // items
    Route::get('/items', [ItemController::class, 'index'])->name('items');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

    // item allergens
    Route::get('allergens', [AllergenController::class, 'allergens'])->name('allergens');
    Route::post('allergens', [AllergenController::class, 'storeAllergens'])->name('allergens.store');
    Route::put('allergens/{allergen}', [AllergenController::class, 'updateAllergens'])->name('allergens.update');
    Route::delete('allergens/{allergen}', [AllergenController::class, 'destroyAllergens'])->name('allergens.destroy');

    // orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});
