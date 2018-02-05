<?php

namespace App\Http\Vendor\Timeline\ViewComposers;

use Illuminate\Foundation\Auth\User;
use Illuminate\View\View;

/**
 * Class TimelinesComposer
 *
 * Initialized in TimelineModuleServiceProvider vendor folder.
 *
 * @package App\Http\Vendor\Timeline\ViewComposers
 */
class TimelineIndexComposer
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
        $view->with('creator', User::first());
    }
}