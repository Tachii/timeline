<?php

namespace B4u\TimelineModule\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

class TimelineEventListener
{
    /**
     * list of listened models
     * @var array
     */
    protected $listenModels;

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
        dd($event);
        $this->logService->addLog($event, 'created');
        Log::info('logs event created: ' . json_encode($event));
    }

    public function logUpdatingAction($event)
    {
        $this->logService->addLog($event, 'updated');
        Log::info('logs event update: ' . json_encode($event));
    }

    public function logDeletingAction($event)
    {
        $this->logService->addLog($event, 'deleted');
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
                    'Modules\Logs\Listeners\LogsListener@log' . ucfirst($eventType) . 'Action'
                );
            }
        }
    }
}
