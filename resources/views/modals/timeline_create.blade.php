<div class="modal fade" id="taskCreateModal" tabindex="-1" role="dialog" aria-labelledby="taskCreateModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="taskCreateModalLabel">@lang('timeline::timeline.new_task')</h4>
            </div>
            {{Form::open(['url' => route('timeline.store'), 'method' => 'post'])}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="description"
                               class="control-label">@lang('timeline::timeline.task_description')</label>
                        <textarea rows="5" name="description" id="description"
                                  placeholder="@lang('timeline::timeline.task_description_placeholder')"
                                  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" data-datepicker=""
                               placeholder="@lang('timeline::timeline.due_date_placeholder')" value="" name="end_date">
                    </div>
                    <div class="form-group">
                        <label for="sel1" class="control-label">@lang('timeline::timeline.responsible_person')</label>
                        <input type="hidden" name="assigned_type" value="{{  get_class($responsibles->first()) }}">
                        <select name="assigned_id"  class="form-control" id="sel1">
                            @foreach($responsibles as $responsible)
                                <option value="{{$responsible->id}}">{{$responsible->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="hidden" name="issuer_id" value="{{$issuer->id}}">
                <input type="hidden" name="issuer_type" value="{{get_class($issuer)}}">
            <input type="hidden" name="target_id" value="{{$target->id}}">
            <input type="hidden" name="target_type" value="{{get_class($target)}}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-simple"
                            data-dismiss="modal">@lang('timeline::timeline.close')</button>
                    <button type="submit" class="btn btn-primary">@lang('timeline::timeline.save')</button>
                </div>
            {{Form::close()}}
        </div>
    </div>
</div>