<?php

use Azuriom\Plugin\Blog\Controllers\Admin\GenerateController;
use Azuriom\Plugin\Blog\Controllers\Admin\PostAttachmentController;
use Azuriom\Plugin\Blog\Controllers\Admin\PostController;
use Azuriom\Plugin\Blog\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware('can:blog.admin')->group(function () {
    Route::resource('posts', PostController::class)->except('show');
    Route::resource('posts.attachments', PostAttachmentController::class)->only('store');

    Route::prefix('posts/attachments')->name('posts.attachments.')->group(function () {
        Route::post('/{pendingId}', [PostAttachmentController::class, 'pending'])->name('pending');
    });

    Route::get('images/search', [PostController::class, 'searchImages'])->name('images.search');

    Route::get('settings', [SettingController::class, 'show'])->name('settings');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::post('generate', [GenerateController::class, 'generate'])->name('generate');
});
