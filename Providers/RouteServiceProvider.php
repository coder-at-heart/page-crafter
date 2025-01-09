<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        Route::middleware(['web', 'moduleEnabled:pagecraft', 'auth:admin', 'setup'])
            ->group(module_path('pagecraft', 'Routes/admin.php', 'app'));

        Route::middleware(['api', 'moduleEnabled:pagecraft'])
            ->group(module_path('pagecraft', 'Routes/api.php', 'app'));
    }
}
