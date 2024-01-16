{{--title--}}
<div class="form-group">
    <label for="title" class="col-form-label text-right required">{{ __('Title') }}</label>
    <div>
        {{ Form::text('title',  null, ['class'=> form_validation($errors, 'title'), 'id' => 'title']) }}
        <span class="invalid-feedback">{{ $errors->first('title') }}</span>
    </div>
</div>
{{--description--}}
<div class="form-group">
    <label for="description"
           class="col-form-label text-right required">{{ __('Description') }}</label>
    <div>
        {{ Form::textarea('description',  null, ['class'=>form_validation($errors, 'description'), 'id' => 'description']) }}
        <span class="invalid-feedback">{{ $errors->first('description') }}</span>
    </div>
</div>
{{--type--}}
<div class="form-group">
    <label for="type" class="col-form-label text-right required">{{ __('Type') }}</label>
    <div class="lf-select">
        {{ Form::select('type', notices_types(), null, ['class'=>form_validation($errors, 'type'), 'placeholder'=> __('Select type'), 'id' => 'type']) }}
    </div>
    <span class="invalid-feedback">{{ $errors->first('type') }}</span>
</div>
{{--visible_type--}}
<div class="form-group">
    <label for="visible_type"
           class="col-form-label text-right required">{{ __('Visibility') }}</label>
    <div class="lf-select">
        {{ Form::select('visible_type', notices_visible_types(), null, ['class'=>form_validation($errors, 'visible_type'), 'placeholder'=> __('Select visible type'), 'id' => 'visible_type']) }}
    </div>
    <span class="invalid-feedback">{{ $errors->first('visible_type') }}</span>
</div>
{{--Start Time--}}
<div class="form-group">
    <label for="start_time" class="col-form-label text-right required">{{ __('Start Time') }}</label>
    <div>
        {{ Form::text('start_at',  null, ['class'=>form_validation($errors, 'start_at'), 'id' => 'start_time']) }}
        <span class="invalid-feedback">{{ $errors->first('start_at') }}</span>
    </div>
</div>
{{--End Time--}}
<div class="form-group">
    <label for="end_time" class="col-form-label text-right required">{{ __('End Time') }}</label>
    <div>
        {{ Form::text('end_at',null, ['class'=>form_validation($errors, 'end_at'), 'id' => 'end_time']) }}
        <span class="invalid-feedback">{{ $errors->first('end_at') }}</span>
    </div>
</div>

{{--Stauts--}}
<div class="form-group">
    <label for="status" class="col-form-label text-right required">{{ __('Status') }}</label>
    <div class="lf-select">
        {{ Form::select('is_active', active_status(), null, ['class'=>form_validation($errors, 'is_active'), 'id' => 'is_active']) }}
    </div>
    <span class="invalid-feedback">{{ $errors->first('is_active') }}</span>
</div>

{{--submit buttn--}}
<div class="form-group">
    {{ Form::submit($buttonText,['class'=>'btn btn-sm btn-info form-submission-button']) }}
    {{ Form::button('<i class="fa fa-undo"></i>',['class'=>'btn btn-sm btn-danger', 'type' => 'reset']) }}
</div>
