<div class="form-group">
    {{Form::label('category-name', __('Category Name'))}}
    {{Form::text('name', null, ['class' => form_validation($errors, 'name')] )}}
    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
</div>
<div class="form-group">
    {{ Form::submit($buttonText,['class'=>'btn btn-info btn-block form-submission-button']) }}
</div>
