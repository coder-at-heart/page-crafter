<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(module_path('pagecraft', 'Resources/Lang', 'app'), 'pagecraft');
        $this->loadViewsFrom(module_path('pagecraft', 'Resources/Views', 'app'), 'pagecraft');
        $this->loadMigrationsFrom(module_path('pagecraft', 'Database/Migrations', 'app'));
        if ($this->app->configurationIsCached()) {
            return;
        }

        $this->loadConfigsFrom(module_path('pagecraft', 'Config', 'app'));
    }

    /**
     * Register the module services.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(TemplateServiceProvider::class);
    }
}
