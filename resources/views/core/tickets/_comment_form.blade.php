<div class="mt-4">
    {{ Form::open(['route' => ['admin.tickets.comment.store',$ticket->id], 'files' => true, 'id' => 'ticketCommentForm']) }}
    <div class="form-group">
        {{ Form::textarea('content', null, ['class' => form_validation($errors, 'content'),'rows'=>'3','placeholder'=>__('Type your message here...')]) }}
        <span class="invalid-feedback my-1">{{ $errors->first('content') }}</span>
        <div class="form-group">
            <input type="file" class="form-check-input d-none" id="fileAttachment" name="attachment">
            <label class="form-check-label bg-gray px-3 py-2 lf-cursor-pointer" for="fileAttachment"><i
                    class="fa fa-paperclip mr-1"></i> {{__('Attachment')}}</label>
            <span class="invalid-feedback my-1">{{ $errors->first('attachment') }}</span>
        </div>
    </div>
    {{ Form::submit('Submit',  ['class' => 'btn bg-secondary form-submission-button text-light px-5']) }}
    {{ Form::close() }}
</div>
