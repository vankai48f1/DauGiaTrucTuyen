@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card-body lf-bg-grey-light">
                    {{ Form::model($notice, ['route'=>['notices.update',  $notice->id], 'method' => 'post', 'class'=>'form-horizontal', 'id' => 'noticeForm']) }}
                    @method('PUT')
                    @include('core.notices._form',['buttonText'=> __('Update')])
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('public/plugins/bs4-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('script')
    @include('core.notices._script')
@endsection
