<?php

namespace B4u\TimelineModule\Models\Traits;

use B4u\TimelineModule\Models\Timeline;

/**
 * Trait AssignedTimelinesModelTrait
 *
 * You include this in a model that must have timelines assigned to it.
 *
 * @package B4u\TimelineModule\Traits
 */
trait TargetTimelineModelTrait
{
    /**
     * @return mixed
     */
    public function targetedTimelines()
    {
        return $this->morphMany(Timeline::class, 'target');
    }
}