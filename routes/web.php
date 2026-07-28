<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicTicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/submit', [PublicTicketController::class, 'create']);
Route::post('/submit', [PublicTicketController::class, 'store']);