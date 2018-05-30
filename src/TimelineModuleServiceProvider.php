<?php

namespace B4u\TimelineModule;

use App\Policies\Vendor\Timeline\TimelinePolicy;
use B4u\TimelineModule\Models\Timeline;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\View;

/**
 * Class TimelineModuleServiceProvider
 * @package B4u\TimelineModule
 */
class TimelineModuleServiceProvider extends AuthServiceProvider
{
    /**
     * Security Policies to authorize actions
     *
     * @var array
     */
    protected $policies = [
        Timeline::class => TimelinePolicy::class,
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
                __DIR__ . '/../database/migrations/create_timeline_table.php.stub' => $this->app->databasePath() . "/migrations/{$timestamp}_create_timeline_table.php",
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
        /*
        View::composer(
            'timeline::modals.timeline_edit_body', \App\Http\Vendor\Timeline\ViewComposers\TimelineEditModalComposer::class
        );*/

        // Loading routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Publish & registering security policies security policies

        $this->publishes([
            __DIR__ . '/Policies' => app_path('Policies/Vendor/Timeline'),
        ]);

        $this->registerPolicies();

        //Publish Config
        $this->publishes([
            __DIR__ . '/../config' => config_path(),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/timeline.php', 'timeline'
        );

    }
}
