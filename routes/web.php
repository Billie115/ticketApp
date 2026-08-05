<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicTicketController;
use App\Http\Controllers\StaffTicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/submit', [PublicTicketController::class, 'create']);
Route::post('/submit', [PublicTicketController::class, 'store']);
Route::get('/ticket/{ticket:uuid}', [PublicTicketController::class, 'show']);
Route::post('ticket/{ticket:uuid}/comment', [PublicTicketController::class, 'addComment']);
Route::get('/staff/tickets', [StaffTicketController::class, 'index']);
Route::get('/staff/tickets/{ticket}', [StaffTicketController::class, 'show']);
Route::patch('/staff/tickets/{ticket}', [StaffTicketController::class, 'update']);
Route::post('/staff/tickets/{ticket}/comment', [StaffTicketController::class, 'addComment']);
Route::post('/staff/tickets/{ticket}/attachment', [StaffTicketController::class, 'addAttachment']);