<?php
use App\Http\Controllers\BusController;
use Illuminate\Support\Facades\Route;

Route::get('find-bus', [BusController::class, 'findBus']);

Route::post('update-route', [BusController::class, 'updateRoute']);

Route::get('routes', [BusController::class, 'showRoutes']);
