<?php

namespace B4u\TimelineModule;

use B4u\TimelineModule\Models\Timeline;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\View;

class TimelineModuleServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Timeline::class => Timeline::class,
    ];

    /**
     * Function fires when you run  'php artisan vendor publish'.
     */
    public function boot()
    {
        // Creating migration with current timestamp of the user.
        if (!class_exists('CreateTimelineTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__ . '/../database/migrations/create_timeline_table.php.stub' => $this->app->databasePath() . "/migrations/{$timestamp}_create_timelines_table.php",
            ], 'migrations');
        }

        // Loading and publishing translations
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang/en', 'timeline');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/timeline'),
        ]);

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/timeline'),
        ]);

        // Loading and publishing views and View composers
        $this->loadViewsFrom(__DIR__ . 'resources/views', 'timeline');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/timeline'),
        ]);

        $this->publishes([
            __DIR__ . '/Http/ViewComposers' => app_path('Http/Vendor/Timeline/ViewComposers'),
        ]);

        // ViewComposers for timelines view
        View::composer(
            'timeline::index', \App\Http\Vendor\Timeline\ViewComposers\TimelineIndexComposer::class
        );

        View::composer(
            'timeline::list', \App\Http\Vendor\Timeline\ViewComposers\TimelineListComposer::class
        );

        View::composer(
            'timeline::modals.timeline_edit_body', \App\Http\Vendor\Timeline\ViewComposers\TimelineEditModalComposer::class
        );

        // Loading routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Publish & registering security policies security policies

        $this->publishes([
            __DIR__ . '/Policies' => app_path('Policies/Vendor/Timeline'),
        ]);

        $this->registerPolicies();
    }
}
