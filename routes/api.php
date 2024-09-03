<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\DepartmentController;use App\Http\Controllers\PurposeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VisitorController;
use App\Events\CheckInUpdated;



Route::middleware('auth:sanctum','checkToken')->group(function () {
    
    Route::get('visitors', [VisitorController::class, 'index']);
    Route::post('visitors', [VisitorController::class, 'store']);
    Route::get('visitors/{id}', [VisitorController::class, 'show']);
    Route::put('visitors/{id}', [VisitorController::class, 'update']);
    Route::delete('visitors/{id}', [VisitorController::class, 'destroy']);
    Route::post('visitors/check-in', [VisitorController::class, 'checkIn']);
    Route::post('visitors/check-out/{id}', [VisitorController::class, 'checkOut']);
    

    Route::get('vehicles', [VehicleController::class, 'index']);
    Route::post('vehicles', [VehicleController::class, 'store']);
    Route::get('vehicles/{id}', [VehicleController::class, 'show']);
    Route::put('vehicles/{id}', [VehicleController::class, 'update']);
    Route::delete('vehicles/{id}', [VehicleController::class, 'destroy']);

    Route::get('purposes', [PurposeController::class, 'index']);
    Route::post('purposes', [PurposeController::class, 'store']);
    Route::get('purposes/{id}', [PurposeController::class, 'show']);
    Route::put('purposes/{id}', [PurposeController::class, 'update']);
    Route::delete('purposes/{id}', [PurposeController::class, 'destroy']);

    Route::get('departments', [DepartmentController::class, 'index']);
    Route::post('departments', [DepartmentController::class, 'store']);
    Route::get('departments/{id}', [DepartmentController::class, 'show']);
    Route::put('departments/{id}', [DepartmentController::class, 'update']);
    Route::delete('departments/{id}', [DepartmentController::class, 'destroy']);

    Route::get('check-ins', [CheckInController::class, 'index']);
    Route::post('add-check-ins', [CheckInController::class, 'store']);
    Route::get('check-ins/{id}', [CheckInController::class, 'show']);
    Route::put('check-out/{id}', [CheckInController::class, 'update']);
    Route::delete('checkDel/{id}', [CheckInController::class, 'destroy']);

    Route::get('roles', [RoleController::class, 'index']);
    Route::post('roles', [RoleController::class, 'store']);
    Route::get('roles/{id}', [RoleController::class, 'show']);
    Route::put('roles/{id}', [RoleController::class, 'update']);
    Route::delete('roles/{id}', [RoleController::class, 'destroy']);

    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);


    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});


Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

