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

        // permission for report manager
        Gate::define('manage-report', function (User $user) {
            return $user->isManager() || $user->isSuperAdmin();
        });

        // permission for view Apps
        Gate::define('view-inventory', function (User $user) {
            return $user->isSuperAdmin() || $user->isManager();
        });
        Gate::define('view-sales', function (User $user) {
            return $user->isSuperAdmin() || $user->isSales() || $user->isManager();
        });
        Gate::define('view-purchase', function (User $user) {
            return $user->isSuperAdmin() || $user->isPurchase() || $user->isManager();
        });

        // permission for view history
        Gate::define('view-sales-history', function (User $user) {
            return $user->isSales();
        });
        Gate::define('view-purchase-history', function (User $user) {
            return $user->isPurchase();
        });

        // Permission for manage Apps
        Gate::define('manage-inventory', function (User $user) {
            return $user->isSuperAdmin();
        });
        Gate::define('manage-sales', function (User $user) {
            return $user->isSuperAdmin() || $user->isSales();
        });
        Gate::define('manage-purchase', function (User $user) {
            return $user->isSuperAdmin() || $user->isPurchase();
        });
    }
}
