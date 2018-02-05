<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="timelineEditModalLabel">Timeline add</h4>
        </div>
        {{Form::open(['url' => route('timeline.update', ['task' => $timeline->id]), 'method' => 'patch'])}}
        <div class="modal-body">
            <div class="form-group">
                    <textarea name="description" id="editor-field-2" cols="30" rows="10"
                              class="textarea-tinymce form-control">
                        {!! $timeline->description !!}
                    </textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-simple" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        {{Form::close()}}
    </div>
</div>