<?php

use Azuriom\Plugin\Blog\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('index');
Route::get('/{slug}', [PostController::class, 'show'])->name('show');
