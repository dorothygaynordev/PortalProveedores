<?php

use App\Http\Controllers\{ArticlesController,InventoryController, StoreController,ProvidersController};

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
    return view('login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('home/{provider_id}', [ArticlesController::class, 'index'])->name('ArticlesAll'); Mostrar articulos filtrados por proveedor
Route::get('home', [ArticlesController::class, 'index'])->name('ArticlesAll');
Route::get('detailWeek', [InventoryController::class,'index'])->name('detailWeek');
Route::get('detailStore', [StoreController::class,'index'])->name('detailStore');

// Route::get('/stock', [StockStoreController::class, 'index'])->name('Stock');
Route::get('/buscar', 'SearchController@buscar')->name('buscar');

Route::get('register', [ProvidersController::class, 'index'])->name('register');






