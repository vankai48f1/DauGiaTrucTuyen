@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    {{  $dataTable['filters'] }}
                    <div class="py-4">
                        @component('components.table',['class'=> 'lf-data-table'])
                            @slot('thead')
                                <tr class="auctioneer-primary-color text-light">
                                    <th class="all">{{ __('Name') }}</th>
                                    <th class="min-phone-l">{{ __('Slug') }}</th>
                                    <th class="text-right all no-sort">{{ __('Action') }}</th>
                                </tr>
                            @endslot

                            @foreach($dataTable['items'] as $category)
                                <tr>
                                    <td>{{ $category->name}}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td class="lf-action text-light">
                                        <div class="btn-group">
                                            <button class="btn btn-info dropdown-toggle"
                                                    data-toggle="dropdown">
                                                <i class="fa fa-gear"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ route('admin.categories.edit',$category->id)}}"><i
                                                        class="fa fa-pencil-square-o fa-lg text-info"></i> {{ __('Edit Info') }}
                                                </a>
                                                <a class="dropdown-item confirmation" data-alert="{{__('Are you sure?')}}"
                                                   data-form-id="urm-{{$category->id}}" data-form-method='delete'
                                                   href="{{ route('admin.categories.destroy',$category->id) }}">
                                                    <i class="fa fa-trash-o"></i> {{ __('Delete') }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endcomponent
                    </div>
                    {{ $dataTable['pagination'] }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    @include('layouts.includes.list-css')
@endsection

@section('script')
    @include('layouts.includes.list-js')
@endsection
