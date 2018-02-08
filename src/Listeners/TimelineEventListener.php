<?php

namespace B4u\TimelineModule\Listeners;

use B4u\TimelineModule\Models\Timeline;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class TimelineEventListener
 * @package B4u\TimelineModule\Listeners
 */
class TimelineEventListener
{
    /**
     * @var array
     */
    private static $exceptLog = [
        'id',
        'remember_token',
        'updated_at',
        'created_at',
        'last_log_in',

        'issuer_id',
        'issuer_type',

        'target_id',
        'target_type',

        'assigned_id',
        'assigned_type',
    ];

    /**
     * list of listened models
     * @var array
     */
    protected $listenModels = [];

    /**
     * TimelineEventListener constructor.
     */
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
                'description' => Auth::user()->name . ' ' . 'created ' . class_basename($event) . ': ' . $event->description
            ]
        );
        Log::info('logs event created: ' . json_encode($event));
    }

    /**
     * @param $event
     */
    public function logUpdatingAction($event)
    {
        Timeline::create(
            [
                'creator_id' => Auth::user()->id,
                'creator_type' => get_class(Auth::user()),
                'target_id' => $event->target_id,
                'target_type' => $event->target_type,
                'description' => Auth::user()->name . ' ' . 'updated ' . class_basename($event) . ' : ' . $this->getChanges($event)
            ]
        );
        Log::info('logs event update: ' . json_encode($event));
    }

    /**
     * @param $entity
     * @return string
     */
    private function getChanges($entity)
    {
        $originalAttributes = $entity->getOriginal();
        $dirtyAttributes = $entity->getDirty();


        foreach (self::$exceptLog as $value) {
            if (isset($originalAttributes[$value])) {
                unset($originalAttributes[$value]);
            }
            if (isset($dirtyAttributes[$value])) {
                unset($dirtyAttributes[$value]);
            }
        }


        foreach ($originalAttributes as $k => $v) {
            if (!isset($dirtyAttributes[$k]))
                unset ($originalAttributes[$k]);
        }


        return $this->implodeWithKeys($originalAttributes) . ' => ' . $this->implodeWithKeys($dirtyAttributes);
    }

    /**
     * @param array $array
     * @return string
     */
    private function implodeWithKeys(array $array): string
    {
        return implode(' ', array_map(
            function ($v, $k) {
                return sprintf("%s='%s'", $k, $v);
            },
            $array,
            array_keys($array)
        ));
    }

    /**
     * @param $event
     */
    public function logDeletingAction($event)
    {
        Timeline::create(
            [
                'creator_id' => Auth::user()->id,
                'creator_type' => get_class(Auth::user()),
                'target_id' => $event->target_id,
                'target_type' => $event->target_type,
                'description' => Auth::user()->name . ' ' . 'deleted ' . class_basename($event) . ' : ' . $event->description
            ]
        );
        Log::info('logs event deleting: ' . json_encode($event));
    }

    /**
     * @param $event
     */
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
