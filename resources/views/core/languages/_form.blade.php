<div class="form-group">
    {{ Form::label('name', __('Name')) }}
    {{ Form::text('name', null, ['class' => form_validation($errors, 'name')]) }}
    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
</div>

<div class="form-group">
    {{ Form::label('short_code', __('Short Code')) }}
    {{ Form::text('short_code', null, ['class' => form_validation($errors, 'short_code')]) }}
    <span class="invalid-feedback">{{ $errors->first('short_code') }}</span>
</div>

<div class="form-group">
    {{ Form::label('icon', __('Icon'), ['class' => 'd-block']) }}
    <div class="fileinput fileinput-new" data-provides="fileinput">
        @if(isset($language) && $language->icon)
            <div class="fileinput-new img-thumbnail lf-w-120px lf-h-80px">
                <img  alt="..."
                     src="{{ get_language_icon($language->icon) }}">
            </div>
        @else
            <div class="fileinput-new img-thumbnail lf-w-120px lf-h-80px">
                <i class="fa fa-image fa-5x"></i>
            </div>
        @endif
            <div class="fileinput-preview fileinput-exists img-thumbnail lf-w-120px lf-h-80px"></div>
        <div>
            <span id="button-group" class="btn btn-sm btn-outline-success btn-file">
                <span class="fileinput-new">{{ __('Select Icon') }}</span>
                <span class="fileinput-exists">{{ __('Change') }}</span>
                    {{ Form::file('icon', ['id' => 'icon']) }}
            </span>

            <a href="#" id="remove" class="btn btn-sm btn-outline-danger fileinput-exists"
               data-dismiss="fileinput">{{ __('Remove') }}</a>
            <span class="invalid-feedback">{{ $errors->first('icon') }}</span>
        </div>
    </div>
</div>

@isset($language)
    <div class="form-group">
        {{ Form::label('is_active', __('Status')) }}
        <div class="lf-select">
        {{ Form::select('is_active', active_status(), null, ['class' => form_validation($errors, 'is_active')]) }}
        </div>
        <span class="invalid-feedback">{{ $errors->first('is_active') }}</span>
    </div>
@endisset

<div class="form-group">
    {{ Form::submit($buttonText,  ['class' => 'btn btn-sm btn-info form-submission-button']) }}
    {{ Form::button('<i class="fa fa-undo"></i>',['class'=>'btn btn-danger btn-sm btn-sm-block reset-button']) }}
</div>
