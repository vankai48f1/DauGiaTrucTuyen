{{ Form::model($store, ['route'=>['admin.stores.update', $store->id], 'id' => 'store-form', 'files' => true, 'method' => 'put']) }}
<div class="form-group">
    {{Form::text('name', null, ['class' => form_validation($errors, 'name'), 'placeholder' => 'Name'] )}}
    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
</div>
<div class="form-group">
    {{Form::text('phone_number', null, ['class' => form_validation($errors, 'phone_number'), 'placeholder' => 'Phone Number'] )}}
    <span class="invalid-feedback">{{ $errors->first('phone_number') }}</span>
</div>

<div class="form-group">
    {{Form::email('email', null, ['class' => form_validation($errors, 'email'), 'placeholder' => 'Email Address'] )}}
    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
</div>

<div class="form-group">
    {{Form::textarea('description', null, ['class' => form_validation($errors, 'description'), 'id' => 'description', 'rows' => '3', 'placeholder' => 'Description about the Store',] )}}
    <span class="invalid-feedback">{{ $errors->first('description') }}</span>
</div>

<div class="form-group">
    <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new img-thumbnail mb-3">
                <img class="img h-100" src="{{get_seller_profile_image($store->image)}}" alt="">
            </div>
            <div class="fileinput-preview fileinput-exists mb-3 img-thumbnail"></div>
            <div>
                <span class="btn btn-sm btn-outline-success btn-file">
                    <span class="fileinput-new">{{ __('Select') }}</span>
                    <span class="fileinput-exists">{{ __('Change') }}</span>
                    {{ Form::file('image', ['class'=>'multi-input', 'id' => 'image',])}}
                </span>
                <a href="#" class="btn btn-sm btn-outline-danger fileinput-exists"
                   data-dismiss="fileinput">{{ __('Remove') }}</a>
            </div>
        </div>
    </div>

    <h4 class="font-weight-bold border-bottom color-666 pb-3">{{ __('Store Image') }}</h4>
    <p class="text-muted mt-4">{{ __("Upload a picture here which will be displayed in you store as your store profile
        image. Anyone will be able to see this image") }}</p>
    <p class="mt-3 mb-0 color-333"> - {{ __('Maximum Image Size') }} : <span class="font-weight-bold">{{ __('5MB') }}</span></p>
    <p class="mt-1 color-333">- {{ __('Maximum Image Dimension') }} : <span class="font-weight-bold">1600x1200</span></p>
    <span class="invalid-feedback">{{ $errors->first('image') }}</span>
</div>

<div class="form-group">
    {{Form::select('is_active', seller_account_status(), null, ['class' => form_validation($errors, 'is_active')] )}}
    <span class="invalid-feedback">{{ $errors->first('is_active') }}</span>
</div>

{{ Form::submit(__('Update'), ['class'=>'btn btn-info px-4 mt-2']) }}
{{ Form::close() }}
