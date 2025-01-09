<?php

use App\Modules\Pagecraft\Http\Controllers\Api\ContentController;
use Illuminate\Support\Facades\Route;

Route::name('api.')
    ->prefix('v1/api')
    ->group(static function (): void {
        Route::get('/cms/content/{page}', ContentController::class)->name('cms.content');
    });
