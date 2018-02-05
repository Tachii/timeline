<?php
/**
 * Created by PhpStorm.
 * User: glebzaveruha
 * Date: 2/1/18
 * Time: 11:57 AM
 */

Route::resource('timeline', \B4u\TimelineModule\Http\Controllers\TimelineController::class)->middleware('web');