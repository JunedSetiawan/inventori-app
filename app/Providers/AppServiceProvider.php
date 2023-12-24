<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use ProtoneMedia\Splade\Facades\SEO;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   // currency format rupiah
        Blade::directive('idr', function ($money) {
            return "<?= 'Rp. ' . number_format($money,2); ?>";
        });

        SEO::metaByName('theme-color', '#D926A9');

        Gate::define('manage-report', function (User $user) {
            return $user->isManager() || $user->isSuperAdmin();
        });

        // permission for view inventory
        Gate::define('view-inventory', function (User $user) {
            return $user->isSuperAdmin() || $user->isManager();
        });
    }
}
