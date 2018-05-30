<?php

namespace B4u\TimelineModule;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 * @package B4u\TimelineModule
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * List of subscribed listeners
     * @var array
     */
    protected $subscribe = [
        //TimelineEventListener::class
    ];
}
