<?php

namespace Modules\Logs\Providers;

use B4u\TimelineModule\Listeners\TimelineEventListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * List of subscribed listeners
     * @var array
     */
    protected $subscribe = [
        TimelineEventListener::class
    ];
}
