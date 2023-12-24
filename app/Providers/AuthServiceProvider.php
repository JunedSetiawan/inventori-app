<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Inventori;
use App\Models\Purchase;
use App\Models\Sales;
use App\Policies\InventoriPolicy;
use App\Policies\PurchasePolicy;
use App\Policies\SalesPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Inventori::class => InventoriPolicy::class,
        Sales::class => SalesPolicy::class,
        Purchase::class => PurchasePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
