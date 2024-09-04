<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VisitorController;


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
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('admin')->group(function () {
        Route::get('index', [AdminController::class, 'index'])->name('admin.index');  
        Route::get('create', [AdminController::class, 'create'])->name('admin.create'); 
        Route::post('store', [AdminController::class, 'store'])->name('admin.store');   
        Route::get('{id}', [AdminController::class, 'show'])->name('admin.show');      
        Route::get('{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');   
        Route::put('{id}', [AdminController::class, 'update'])->name('admin.update');    
        Route::delete('{id}', [AdminController::class, 'destroy'])->name('admin.destroy'); 
    });
    Route::prefix('visitors')->group(function () {
        Route::get('index', [VisitorController::class, 'index'])->name('visitors.index');  
        Route::get('create', [VisitorController::class, 'create'])->name('visitors.create'); 
        Route::post('store', [VisitorController::class, 'store'])->name('visitors.store');   
        Route::get('{id}', [VisitorController::class, 'show'])->name('visitors.show');      
        Route::get('{id}/edit', [VisitorController::class, 'edit'])->name('visitors.edit');   
        Route::put('{id}', [VisitorController::class, 'update'])->name('visitors.update');    
        Route::delete('{id}', [VisitorController::class, 'destroy'])->name('visitors.destroy'); 
    });

    // Define the dashboard route with the name
    Route::get('/dashboard', function () {
        return view('layouts.master');
    })->name('dashboard');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // Route to handle login submission
    Route::post('/loginSubmit', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/', function () {
        return view('index');
    });

});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


