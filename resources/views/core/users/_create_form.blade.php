{{--first name--}}
<div class="form-group mb-1">
    <label for="first_name" class="col-form-label text-right required">{{ __('First Name') }}</label>
    <div>
        {{ Form::text('first_name',  null, ['class'=>form_validation($errors, 'first_name'), 'id' => 'first_name']) }}
        <span class="invalid-feedback">{{ $errors->first('first_name') }}</span>
    </div>
</div>
{{--last name--}}
<div class="form-group mb-1">
    <label for="last_name"
           class="col-form-label text-right required">{{ __('Last Name') }}</label>
    <div>
        {{ Form::text('last_name',  null, ['class'=>form_validation($errors, 'last_name'), 'id' => 'last_name']) }}
        <span class="invalid-feedback">{{ $errors->first('last_name') }}</span>
    </div>
</div>
{{--email--}}
<div class="form-group mb-1">
    <label for="email" class="col-form-label text-right required">{{ __('Email') }}</label>
    <div>
        {{ Form::email('email',null, ['class'=>form_validation($errors, 'email'), 'id' => 'email']) }}
        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
    </div>
</div>
{{--username--}}
<div class="form-group mb-1">
    <label for="username"
           class="col-form-label text-right required">{{ __('Username') }}</label>
    <div>
        {{ Form::text('username', null, ['class'=>form_validation($errors, 'username'), 'id' => 'username']) }}
        <span class="invalid-feedback">{{ $errors->first('username') }}</span>
    </div>
</div>
{{--address--}}
<div class="form-group mb-1">
    <label for="address" class="col-form-label text-right">{{ __('Address') }}</label>
    <div>
        {{ Form::textarea('address',null, ['class'=>form_validation($errors, 'address'), 'id' => 'address', 'rows'=>2]) }}
        <span class="invalid-feedback">{{ $errors->first('address') }}</span>
    </div>
</div>

{{--user group field--}}
<div class="form-group mb-1">
    <label for="assigned_role"
           class="col-form-label text-right required">{{ __('User Role') }}</label>
    <div>
        <div class="lf-select">
            {{ Form::select('assigned_role', $roles, null,['class' => form_validation($errors, 'assigned_role'),'id' => 'assigned_role', 'placeholder' => __('Select Role')]) }}
        </div>
        <span class="invalid-feedback">{{ $errors->first('assigned_role') }}</span>
    </div>
</div>
{{--user email status--}}
<div class="form-group mb-1">
    <label for="is_email_verified"
           class="col-form-label text-right required">{{ __('Email Status') }}</label>
    <div>
        <div class="lf-select">
            {{ Form::select('is_email_verified', email_status(), null, ['class' => form_validation($errors, 'is_email_verified'),'id' => 'is_email_verified']) }}
        </div>
        <span class="invalid-feedback">{{ $errors->first('is_email_verified') }}</span>
    </div>
</div>
{{--user status--}}
<div class="form-group mb-1">
    <label for="status"
           class="col-form-label text-right required">{{ __('Account Status') }}</label>
    <div>
        <div class="lf-select">
            {{ Form::select('status', account_status(), null, ['class' => form_validation($errors, 'status'),'id' => 'status']) }}
        </div>
        <span class="invalid-feedback">{{ $errors->first('status') }}</span>
    </div>
</div>
{{--user financial status--}}
<div class="form-group mb-1">
    <label for="is_financial_active"
           class="col-form-label text-right required">{{ __('Financial Status') }}</label>
    <div>
        <div class="lf-select">
            {{ Form::select('is_financial_active', financial_status(), null, ['class' => form_validation($errors, 'is_financial_active'),'id' => 'is_financial_active']) }}
        </div>
        <span class="invalid-feedback">{{ $errors->first('is_financial_active') }}</span>
    </div>
</div>
{{--user maintenance accessible status--}}
<div class="form-group mb-4">
    <label for="is_accessible_under_maintenance"
           class="col-form-label text-right required">{{ __('Maintenance Access Status') }}</label>
    <div>
        <div class="lf-select">
            {{ Form::select('is_accessible_under_maintenance', maintenance_accessible_status(), null, ['class' => form_validation($errors, 'is_accessible_under_maintenance'),'id' => 'is_accessible_under_maintenance']) }}
        </div>
        <span class="invalid-feedback">{{ $errors->first('is_accessible_under_maintenance') }}</span>
    </div>
</div>


{{--submit buttn--}}
<div class="form-group">
    {{ Form::submit(__('Create'),['class'=>'btn btn-sm btn-info form-submission-button']) }}
    {{ Form::button('<i class="fa fa-undo"></i>',['class'=>'btn btn-sm btn-danger', 'type' => 'reset']) }}
</div>
