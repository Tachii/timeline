<?php

namespace B4u\TimelineModule\Http\Controllers;

use B4u\TimelineModule\Http\Requests\TimelineStoreRequest;
use B4u\TimelineModule\Http\Requests\TimelineUpdateRequest;
use B4u\TimelineModule\Models\Timeline;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

/**
 * Class TimelineController
 * @package B4u\TimelineModule\Http\Controllers
 */
class TimelineController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->authorizeResource(Timeline::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TimelineStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimelineStoreRequest $request)
    {
        try {
            Timeline::create($request->all());
            return redirect()->back()->with(
                'success',
                trans('timeline::timeline.saved_text')
            );
        } catch (\Exception $exception) {
            Log::error('Timeline save error: ' . $exception->getMessage());
            return redirect()->back()->withErrors(['message' => trans('timeline::timeline.error_text')])->withInput($request->all());
        }
    }

    /**
     * @param Timeline $timeline
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function edit(Timeline $timeline)
    {
        return response()->view('timeline::modals.timeline_edit_body', ['timeline' => $timeline], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param TimelineUpdateRequest $request
     * @param Timeline $timeline
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(TimelineUpdateRequest $request, Timeline $timeline)
    {
        try {
            $timeline->fill($request->all())->save();
            return redirect()->back()->with(
                'success',
                trans('timeline::timeline.saved_text')
            );
        } catch (\Exception $exception) {
            Log::error('Timeline save error: ' . $exception->getMessage());
            return redirect()->back()->withErrors(['message' => trans('timeline::timeline.error_text')])->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Timeline $timeline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timeline $timeline)
    {
        try {
            $timeline->delete();
            return redirect()->back()->with(
                'success',
                trans('timeline::timeline.deleted_text')
            );
        } catch (\Exception $exception) {
            Log::error('Timeline delete error: ' . $exception->getMessage());
            return redirect()->back()->withErrors(['message' => trans('timeline::timeline.error_text')]);
        }
    }
}
