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
Route::post('/ticket/{ticket:uuid}/comment', [PublicTicketController::class, 'addComment']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/staff/tickets', [StaffTicketController::class, 'index']);
    Route::get('/staff/tickets/{ticket}', [StaffTicketController::class, 'show']);
    Route::patch('/staff/tickets/{ticket}', [StaffTicketController::class, 'update']);
    Route::post('/staff/tickets/{ticket}/comment', [StaffTicketController::class, 'addComment']);
    Route::post('/staff/tickets/{ticket}/attachment', [StaffTicketController::class, 'addAttachment']);
});

require __DIR__.'/auth.php';