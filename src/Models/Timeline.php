<?php

namespace B4u\TimelineModule\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Timeline
 *
 * Model entity for Timeline.
 *
 * @package B4u\TimelineModule\Models
 */
class Timeline extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'description',
        'creator_id',
        'creator_type',
        'target_id',
        'target_type',
    ];

    protected $table = 'timeline';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('updated_at_desc', function (Builder $builder) {
            $builder->orderBy('updated_at', 'desc');
        });
    }

    /**
     *
     * Entity that created timeline record
     *
     * @return MorphTo
     */
    public function creator(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     *
     * Entity that is related to the timeline record
     *
     * @return MorphTo
     */
    public function target(): MorphTo
    {
        return $this->morphTo();
    }
}