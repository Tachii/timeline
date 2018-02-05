<?php

namespace App\Policies\Vendor\Timeline;

use B4u\TimelineModule\Models\Timeline;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class TimelinePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Timeline.
     *
     * @param  User $user
     * @param  Timeline $timeline
     * @return bool
     */
    public function view(User $user, Timeline $timeline): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create timeline.
     *
     * @param  User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the Timeline.
     *
     * @param  User $user
     * @param  Timeline $timeline
     * @return mixed
     */
    public function update(User $user, Timeline $timeline): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the Timeline.
     *
     * @param  User $user
     * @param  Timeline $timeline
     * @return mixed
     */
    public function delete(User $user, Timeline $timeline): bool
    {

        return true;
    }
}
