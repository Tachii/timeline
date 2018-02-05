<div class="panel-heading">
    <div class="flex-head">
        <div class="flex-head-direction">
            <div class="flex-head-item">
                <div class="panel-title">@lang('timeline::timeline.label')</div>
            </div>
        </div>
        <div class="flex-head-direction">
            @can('create', \B4u\TimelineModule\Models\Timeline::class)
                <div class="flex-head-item">
                    <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#taskCreateModal">
                        <em>@lang('timeline::timeline.button_create_new')</em>
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </div>
            @endcan
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@include('timeline::list')
@include('timeline::modals.timeline_create')
@include('timeline::modals.timeline_edit')