<?php

use App\Modules\Pagecraft\Http\Controllers\Admin\MediaController;
use App\Modules\Pagecraft\Http\Controllers\Admin\PagecraftController;
use Illuminate\Support\Facades\Route;

Route::name('admin.pagecraft.')
    ->prefix('admin/pagecraft')
    ->group(static function (): void {
        Route::get('/', [PagecraftController::class, 'index'])->name('index');
        Route::get('create', [PagecraftController::class, 'create'])->name('create');
        Route::get('{page}/edit', [PagecraftController::class, 'edit'])->name('edit');
        Route::delete('{page}', [PagecraftController::class, 'destroy'])->name('destroy');
        Route::put('{page}', [PagecraftController::class, 'update'])->name('update');
        Route::post('media/upload', [MediaController::class, 'upload'])->name('media.upload');
        Route::get('media/{media}', [MediaController::class, 'show'])->name('media.show');
    });
