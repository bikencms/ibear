<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StoreController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::get('/login', [LoginController::class, 'login']);
Route::get('/', [HomeController::class, 'index'])->name('shop_index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop_home');
Route::get('/store', [StoreController::class, 'index'])->name('store_index');
Route::get('/shop/{id}', [ShopController::class, 'shop'])->name('shop.detail');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/dashboard/product', [ProductController::class, 'index'])->middleware(['auth'])->name('dashboard.product');
Route::get('/dashboard/product/add', [ProductController::class, 'add'])->middleware(['auth'])->name('dashboard.product.add');
Route::post('/dashboard/product/store', [ProductController::class, 'store'])->middleware(['auth'])->name('dashboard.product.store');

Route::get('/dashboard/post', [PostController::class, 'index'])->middleware(['auth'])->name('dashboard.post');
Route::get('/dashboard/post/add', [PostController::class, 'add'])->middleware(['auth'])->name('dashboard.post.add');
require __DIR__.'/auth.php';
