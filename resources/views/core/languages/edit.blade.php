@extends('layouts.master')

@section('title', $title)

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card-body lf-bg-grey-light">
                            {{ Form::model($language, ['route' => ['languages.update', $language->id], 'files' => true, 'method'=> 'put', 'id' => 'languageForm']) }}
                            @include('core.languages._form', ['buttonText' => __('Update')])
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
