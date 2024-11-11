<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('chat', [ChatController::class, 'chat'])->name('chat');
Route::post('generate-text', [ChatController::class, 'submitChat'])->name('submit-chat');