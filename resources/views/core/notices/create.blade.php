@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="card-body lf-bg-grey-light">
                    {{ Form::open(['route'=>'notices.store', 'method' => 'post', 'class'=>'form-horizontal', 'id' => 'noticeForm']) }}
                    @include('core.notices._form',['buttonText'=> __('Create')])
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
