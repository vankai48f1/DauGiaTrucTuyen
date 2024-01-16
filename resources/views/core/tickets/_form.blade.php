{{--title--}}
<div class="form-group">
    <label for="title" class="required">{{ __('Heading') }}</label>
    {{ Form::text('title', null, ['class' => form_validation($errors, 'title'), 'id' => 'title']) }}

    <span class="invalid-feedback">{{ $errors->first('title') }}</span>
</div>

{{--content--}}
<div class="form-group">
    <label for="content_textarea" class="required">{{ __('Description') }}</label>
        {{ Form::textarea('content', null, ['class' => form_validation($errors, 'content'), 'rows'=>3, 'id' => 'content_textarea']) }}

        <span class="invalid-feedback">{{ $errors->first('content') }}</span>
</div>

{{--Previous Ref Id--}}
<div class="form-group">
    <label for="previous_id" class="required">{{ __('Previous Ref Id') }}</label>
    {{ Form::text('previous_id', null, ['class' => form_validation($errors, 'previous_id'), 'id' => 'previous_id']) }}

    <span class="invalid-feedback">{{ $errors->first('previous_id') }}</span>
</div>

{{--file--}}
<div class="form-group">
    <input type="file" class="form-check-input d-none" id="fileAttachment" name="attachment">
    <label class="form-check-label bg-gray px-3 py-2 lf-cursor-pointer" for="fileAttachment"><i
            class="fa fa-paperclip mr-1"></i> {{__('Attachment')}}</label>
    <span class="invalid-feedback my-1">{{ $errors->first('attachment') }}</span>
</div>

{{--submit button--}}
<div class="form-group">
    {{ Form::submit($buttonText.' Ticket',['class'=>'btn btn-success form-submission-button']) }}
</div>
