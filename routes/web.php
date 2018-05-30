<?php

Route::resource('timeline', \B4u\TimelineModule\Http\Controllers\TimelineController::class)->middleware('web');