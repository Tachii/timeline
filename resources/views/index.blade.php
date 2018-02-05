<div class="panel-heading">
    <div class="flex-head">
        <div class="flex-head-direction">
            <div class="flex-head-item">
                <div class="panel-title">@lang('timeline::timeline.label')</div>
            </div>
        </div>
        <div class="flex-head-direction">
            <div class="flex-head-item">
                <a href="#" class="timeline_save btn btn-primary">
                    <em>Toevoegen</em>
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
            </div>
        </div>
    </div>
</div>
{{Form::open(['url' => route('timeline.store'), 'method' => 'post', ['id' => 'timelineStore']])}}
{{Form::hidden('creator_id', $creator->id)}}
{{Form::hidden('creator_type', get_class($creator))}}
<div class="form-group">
    <textarea name="description" id="editor-field-1" cols="30" rows="10"
              class="textarea-tinymce form-control"></textarea>
    </div>
{{Form::close()}}

@include('timeline::list')

@push('scripts')
    <script type="text/javascript">
        $(".timeline_save").on('click', function () {
            $('#timelineStore').submit();
        });
    </script>
@endpush