<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;

use App\Models\Training;
use App\Models\Department;

use App\Models\Notification;
use App\Models\TrainingProvider;

use App\Policies\TrainingPolicy;
use App\Policies\DepartmentPolicy;

use App\Policies\NotificationPolicy;
use Illuminate\Support\Facades\Gate;
use App\Policies\TrainingProviderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Department::class => DepartmentPolicy::class,
        // Training::class => TrainingPolicy::class,
        // TrainingProvider::class => TrainingProviderPolicy::class,
        // Notification::class => NotificationPolicy::class,
    ];

    // -- Register services.
    public function register(): void {}

    // -- Bootstrap services.
    public function boot(): void
    {
        // Implicitly grant "almighty" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('almighty') ? true : null;
        });

        $this->registerPolicies();
    }
}
