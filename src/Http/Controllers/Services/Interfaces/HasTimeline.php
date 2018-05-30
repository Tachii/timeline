<?php

namespace B4u\TimelineModule\Http\Services\Interfaces;

use B4u\TimelineModule\Models\Timeline;
use Illuminate\Support\Collection;

/**
 * Interface HasTimeline
 * @package B4u\TasksModule\Http\Services\Interfaces
 */
interface HasTimeline
{
    /**
     * Method to create data array that is needed for creation of the timeline
     *
     * @return array
     */
    public static function getTimelineCreationData(): array;

    /**
     * Method to get timeline records for certain page
     *
     * @return Collection
     */
    public static function getTimeline(): Collection;

    /**
     * Get data related to edited timeline
     *
     * @param Timeline $timeline
     * @return array
     */
    public static function getTimelineEditionData(Timeline $timeline): array;
}