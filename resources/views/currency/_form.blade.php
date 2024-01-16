<div class="form-group form-row">
    <div class="col-md-4">
        {{Form::label('currency-name', __('Currency Name'))}} :
    </div>
    <div class="col-md-8">
        {{Form::text('name', null, ['class' => form_validation($errors, 'name')] )}}
        <span class="invalid-feedback">{{ $errors->first('name') }}</span>
    </div>
</div>

<div class="form-group form-row">
    <div class="col-md-4">
        {{Form::label('symbol', __('Symbol'))}} :
    </div>

    <div class="col-md-8">
        {{Form::text('symbol',null, ['class' => form_validation($errors, 'symbol')] )}}
        <span class="invalid-feedback">{{ $errors->first('symbol') }}</span>
    </div>
</div>

@if( !isset($currency) )
<div class="form-group form-row">
    <div class="col-md-4">
        {{Form::label('type', __('Currency Type'))}} :
    </div>
    @php
        $currencyType = currency_types();
        unset($currencyType[CURRENCY_TYPE_CRYPTO])
    @endphp
    <div class="col-md-8">
        {{Form::select('type', $currencyType, null, [
            'class' => form_validation($errors, 'type', 'custom-select'),
             'placeholder' => __('Select Currency')
         ])}}
        <span class="invalid-feedback">{{ $errors->first('type') }}</span>
    </div>
</div>
@endif
<div class="form-group form-row">
    <div class="col-md-4">
        <label for="customFile">{{ __('Logo') }} :</label>
    </div>
    <div class="col-md-8">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new img-thumbnail mb-3 lf-w-100px lf-h-100px">
                    <img class="img" src="{{currency_logo(isset($currency) ? $currency->logo : '')}}" alt="Image">
                </div>
                <div class="fileinput-preview fileinput-exists mb-3 img-thumbnail lf-w-100px lf-h-100px"></div>
                <div>
                    <span class="btn btn-sm btn-success btn-file">
                        <span class="fileinput-new">{{ __('Select') }}</span>
                        <span class="fileinput-exists">{{ __('Change') }}</span>
                        {{ Form::file('logo')}}
                    </span>
                    <a href="#" class="btn btn-sm btn-outline-danger fileinput-exists" data-dismiss="fileinput">{{ __('Remove') }}</a>
                </div>
            </div>
        </div>
        <span class="invalid-feedback">{{ $errors->first('logo') }}</span>
        <span class="text-muted small">{{ __('Image dimensions equal or less than 100x100 and size 1MB or less') }}</span>
    </div>
</div>

<div class="form-group form-row">
    <div class="col-md-4">
        {{Form::label('is_active', __('Status'))}} :
    </div>
    <div class="col-md-8">
        <div class="lf-switch">
            {{ Form::radio('is_active', ACTIVE, true , ['id' => 'is_active-active', 'class' => 'lf-switch-input']) }}
            <label for="is_active-active" class="lf-switch-label">{{ __('Active') }}</label>

            {{ Form::radio('is_active', INACTIVE, false, ['id' => 'is_active-inactive', 'class' => 'lf-switch-input']) }}
            <label for="is_active-inactive" class="lf-switch-label">{{ __('Inactive') }}</label>
        </div>
        <span class="invalid-feedback">{{ $errors->first('is_active') }}</span>
    </div>
</div>

<div class="form-group mt-3">
    {{ Form::submit($buttonText,['class'=>'btn btn-info btn-block form-submission-button']) }}
</div>
