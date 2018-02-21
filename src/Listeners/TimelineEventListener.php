<?php

namespace B4u\TimelineModule\Listeners;

use B4u\TimelineModule\Models\Timeline;
use Carbon\Carbon;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;

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

    protected $user_name;

    /**
     * TimelineEventListener constructor.
     */
    public function __construct()
    {
        $this->listenModels = config('timeline.listen_models');
        $this->user_name = Auth::user() ? Auth::user()->name : 'System';

    }

    /**
     * Log modified data
     * @param $event
     */
    public function logCreatedAction($event)
    {
        Timeline::create([
            'creator_id' => Auth::user() ? Auth::user()->id : null,
            'creator_type' => Auth::user() ? get_class(Auth::user()) : null,
            'target_id' => $event->target_id,
            'target_type' => $event->target_type,
            'description' => $this->user_name . ' ' . 'created ' . class_basename($event) . ': ' . $event->description
        ]);
    }

    /**
     * @param $event
     */
    public function logUpdatingAction($event)
    {
        Timeline::create(
            [
                'creator_id' => Auth::user() ? Auth::user()->id : null,
                'creator_type' => Auth::user() ? get_class(Auth::user()) : null,
                'target_id' => $event->target_id,
                'target_type' => $event->target_type,
                'description' => $this->user_name . ' ' . 'updated ' . class_basename($event) . ' : ' . $this->getChanges($event)
            ]
        );
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

        if (isset($dirtyAttributes['end_date'])) {
            $dirtyAttributes['end_date'] = Carbon::createFromFormat('Y-m-d', $dirtyAttributes['end_date'])->format(config('date.date_format'));
        }

        if (isset($originalAttributes['end_date'])) {
            $originalAttributes['end_date'] = Carbon::createFromFormat('Y-m-d', $originalAttributes['end_date'])->format(config('date.date_format'));
        }

        $originalAttributes = $this->convertToTitleCase($originalAttributes);
        $dirtyAttributes = $this->convertToTitleCase($dirtyAttributes);

        return $this->implodeWithKeys($originalAttributes) . ' => ' . $this->implodeWithKeys($dirtyAttributes);
    }

    /**
     * Converts array keys to "Title Case"
     *
     * @param $array
     * @return array
     */
    public function convertToTitleCase($array): array
    {
        foreach ($array as $key => $value) {
            unset($array[$key]);
            $key = title_case(str_replace('_', ' ', $key));
            $array[$key] = $value;
        }

        return $array;
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
                'creator_id' => Auth::user() ? Auth::user()->id : null,
                'creator_type' => Auth::user() ? get_class(Auth::user()) : null,
                'target_id' => $event->target_id,
                'target_type' => $event->target_type,
                'description' => $this->user_name . ' ' . 'updated ' . class_basename($event) . ' : ' . $event->description
            ]
        );
    }

    /**
     * @param $event
     */
    public function logRestoringAction($event)
    {
        $this->logService->addLog($event, 'restored');
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
