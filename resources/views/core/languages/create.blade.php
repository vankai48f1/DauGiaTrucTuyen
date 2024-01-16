@extends('layouts.master')

@section('title', $title)

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card-body lf-bg-grey-light">
                            {{ Form::open(['route' => 'languages.store', 'files' => true, 'id' => 'languageForm']) }}
                            @include('core.languages._form', ['buttonText' => __('Create')])
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('public/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endsection

@section('script')
    @include('core.languages._script')
@endsection
