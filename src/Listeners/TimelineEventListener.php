<?php

namespace B4u\TimelineModule\Listeners;

use B4u\TimelineModule\Models\Timeline;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TimelineEventListener
{
    /**
     * list of listened models
     * @var array
     */
    protected $listenModels = [];

    public function __construct()
    {
        $this->listenModels = config('timeline.listen_models');
    }

    /**
     * Log modified data
     * @param $event
     */
    public function logCreatedAction($event)
    {
        Timeline::create(
            [
                'creator_id' => Auth::user()->id,
                'creator_type' => get_class(Auth::user()),
                'target_id' => $event->target_id,
                'target_type' => $event->target_type,
                'description' => Auth::user()->name . ' ' . 'created task'
            ]
        );
        Log::info('logs event created: ' . json_encode($event));
    }

    public function logUpdatingAction($event)
    {
        Timeline::create(
            [
                'creator_id' => Auth::user()->id,
                'creator_type' => get_class(Auth::user()),
                'target_id' => $event->target_id,
                'target_type' => $event->target_type,
                'description' => Auth::user()->name . ' ' . 'updated task'
            ]
        );
        Log::info('logs event update: ' . json_encode($event));
    }

    public function logDeletingAction($event)
    {
        Timeline::create(
            [
                'creator_id' => Auth::user()->id,
                'creator_type' => get_class(Auth::user()),
                'target_id' => $event->target_id,
                'target_type' => $event->target_type,
                'description' => Auth::user()->name . ' ' . 'deleted task'
            ]
        );
        Log::info('logs event deleting: ' . json_encode($event));
    }

    public function logRestoringAction($event)
    {
        $this->logService->addLog($event, 'restored');
        Log::info('logs event restoring: ' . json_encode($event));
    }

    /**
     * Subscribe models events
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        foreach ($this->listenModels as $eventType => $models) {
            foreach ($models as $model) {
                $events->listen(
                    'eloquent.' . $eventType . ': ' . $model,
                    self::class . '@log' . ucfirst($eventType) . 'Action'
                );
            }
        }
    }
}
