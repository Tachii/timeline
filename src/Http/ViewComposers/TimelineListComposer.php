<?php

namespace App\Http\Vendor\Timeline\ViewComposers;

use B4u\TimelineModule\Models\Timeline;
use Illuminate\View\View;

/**
 * Class TimelinesComposer
 *
 * Initialized in TimelineModuleServiceProvider vendor folder.
 *
 * @package App\Http\Vendor\Timeline\ViewComposers
 */
class TimelineListComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        //@TODO Replace data below with actual data, placeholders for now, to demonstrate logic.
        $view->with('timelines', Timeline::all());
    }
}