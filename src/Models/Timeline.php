<?php

namespace B4u\TimelineModule\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    /**
     * @var string
     */
    protected $table = 'timeline';

    /**
     *
     * Setter mutator
     *
     * @param $value
     * @return $this
     */
    public function setEndDateAttribute($value)
    {
        try {
            $this->attributes['end_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
        } catch (\Exception $exception) {
            Log::error('Timeline save error, wrong date params: ' . $exception->getMessage());
            return redirect()->back()->withErrors(['message' => trans('timeline::error_text')]);
        }
    }

    /**
     *
     * Getter mutator
     *
     * @param $value
     * @return string
     */
    public function getEndDateAttribute($value)
    {
        try {
            return Carbon::createFromFormat('Y-m-d', $value)->format('m/d/Y');
        } catch (\Exception $exception) {
            Log::error('Timeline getEndDateAttribute mutator error, wrong date params: ' . $exception->getMessage());
            return $value;
        }
    }


    /**
     *
     * Entity that created timeline record
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function creator()
    {
        return $this->morphTo();
    }

    /**
     *
     * Entity that is related to the timeline record
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function target()
    {
        return $this->morphTo();
    }
}