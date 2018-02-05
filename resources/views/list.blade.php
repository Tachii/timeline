<div class="info-list">
    @if(isset($timelines) && $timelines->isNotEmpty())
        @foreach($timelines as $task)
            <div class="info-item">
                <div class="info-item-content">
                    <h3>{{$task->description}}</h3>
                    <div class="meta">@lang('timeline::timeline.assigned_to')
                        <span class="green-text">{{$task->assigned->name}}</span> @lang('timeline::timeline.due_to')
                        <span class="green-text">{{$task->end_date}}</span>
                    </div>
                </div>
                <div class="info-item-settings">
                    <div class="ii-ssettings-list">
                        @can('update', $task)
                            <a href="#" class="task_edit_handler btn btn-warning btn-sm"
                               data-url="{{route('timeline.edit', ['timeline' => $task->id])}}">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        @endcan
                        @can('delete', $task)
                            {{Form::open(['url' => route('timeline.destroy', ['timeline' => $task->id]), 'method' => 'delete'])}}
                            <a href="#" class="task_delete_handler btn btn-danger btn-sm">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                            {{Form::close()}}
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="panel-body">
            <div class="alert alert-info">@lang('timeline::timeline.no_timelines')</div>
        </div>
    @endif
</div>

@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <script type="text/javascript">

        // Confirmation Popup
        $(".task_delete_handler").click(function (e) {
            e.preventDefault();
            $this = $(this);
            $.confirm({
                title: '',
                content: '<p style="text-align:center;font-size:18px;">{{ trans('timeline::timeline.confirm_delete') }}</p>',
                buttons: {
                    yes: {
                        text: '{{ trans('timeline::timeline.button_yes') }}',
                        btnClass: 'btn-danger',
                        action: function () {
                            $this.parent().submit();
                        }
                    },
                    no: {
                        text: '{{ trans('timeline::timeline.button_no') }}',
                        btnClass: 'btn-blue',
                        action: function () {

                        }
                    }
                }
            });
        });

        // Modal for timeline editing
        $(".task_edit_handler").on('click', function () {
            $.get($(this).data('url'), function (data) {
                $('#taskEditModal').html(data).modal('show').find('[data-datepicker]').datepicker();
            });
        })

    </script>
@endpush