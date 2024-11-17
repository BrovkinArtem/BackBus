<?php
use App\Http\Controllers\BusController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    return view('welcome');
});

// Route::get('api/find-bus', [BusController::class, 'findBus']);

// Route::post('api/update-route', [BusController::class, 'updateRoute']);
