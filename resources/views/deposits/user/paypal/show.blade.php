@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-{{ $type }}">
                    {{ view_html($message) }}
                </div>
            </div>
        </div>
    </div>
@endsection

