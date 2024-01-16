<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            {{Form::label('name', __('Name :'), ['class' => 'text-muted'])}}
            {{Form::text('name', null, ['class' => 'form-control' ] )}}
            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            {{Form::label('phone_number', __('Contact Number :'),['class' => 'text-muted'])}}
            {{Form::text('phone_number', null, ['class' => 'form-control'] )}}
            <span class="invalid-feedback">{{ $errors->first('phone_number') }}</span>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            {{Form::label('address', __('Street Address :'),['class' => 'text-muted'])}}
            {{Form::text('address', null, ['class' => 'form-control',] )}}
            <span class="invalid-feedback">{{ $errors->first('address') }}</span>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            {{Form::label('country', __('Country :'),['class' => 'text-muted'])}}
            {{ Form::select('country_id', $countries, null, ['class'=> 'custom-select country', 'v-on:change'=> "onChange(".'$event'.")", 'id' => 'country_id', 'placeholder' => __('Select Country')]) }}
            <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            {{Form::label('post_code', __('Zip / Post Code :'),['class' => 'text-muted'])}}
            {{Form::text('post_code', null, ['class' => 'form-control', 'id' => 'post_code'] )}}
            <span class="invalid-feedback">{{ $errors->first('post_code') }}</span>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            {{Form::label('city', __('City :'),['class' => 'text-muted'])}}
            {{Form::text('city', null, ['class' => 'form-control',  'id' => 'city' ] )}}
            <span class="invalid-feedback">{{ $errors->first('city') }}</span>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="{{ 'state_id' }}" class="control-label text-muted required">
                {{ __('State :') }}
                <span v-show="isLoading">
                    <i class="fa fa-spinner fa-spin fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </span>
            </label>

            <select class="custom-select" name="state_id" :disabled="disableStateDom">
                <option value="">{{__('Select State')}}</option>
                <option :selected="selectedState === index" v-for="(state, index) in states" :value="index" v-text="state"></option>
            </select>
            <span class="invalid-feedback">{{ $errors->first('state_id') }}</span>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group mb-2">
            {{ Form::submit('Submit',['class'=>'btn btn-info px-4 mt-2 float-right from-submission-button']) }}
        </div>
    </div>
</div>
