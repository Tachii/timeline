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

class TimelineController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->authorizeResource(Timeline::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param  Timeline $timelines
     * @return \Illuminate\Http\Response
     */
    public function show(Timeline $timelines)
    {
        //
    }

    /**
     * @param Timeline $task
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function edit(Timeline $task)
    {
        return response()->view('timeline::modals.task_edit_body', ['timeline' => $task], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param TimelineUpdateRequest $request
     * @param Timeline $task
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(TimelineUpdateRequest $request, Timeline $task)
    {
        try {
            $task->fill($request->all())->save();
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
     * @param  Timeline $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timeline $task)
    {
        try {
            $task->delete();
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
