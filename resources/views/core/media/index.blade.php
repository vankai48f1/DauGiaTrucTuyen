@extends('layouts.master',['fixedSideNav'=>false])

@section('title', $title)

@section('content')
    <div class="container my-3">
        <div class="row">
            <div class="col-12 mb-4">
                @if($pathInfo['currentPath'])
                    @if($pathInfo['upLevelPath'])
                        <a class="btn btn-dark text-light"
                           href="{{ route('admin.media.index',['directory'=>$pathInfo['upLevelPath']]) }}"><i
                                class="fa fa-reply"></i> {{__('Up Level')}}</a>
                    @else
                        <a class="btn btn-dark text-light"
                           href="{{ route('admin.media.index') }}"><i
                                class="fa fa-reply"></i> {{__('Up Level')}}</a>
                @endif
            @endif
            <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadFile">
                    <i class="fa fa-upload"></i> {{ __('Upload') }}
                </button>

                <button class="btn btn-secondary" data-toggle="modal" data-target="#createDirectory"><i
                        class="fa fa-plus"></i> {{__('Create')}}</button>
                <button class="btn btn-info text-dark lf-directory-select"><i
                        class="fa fa-check-square-o"></i> {{__('Select')}}</button>
                <button class="btn btn-info text-dark lf-directory-unselect d-none"><i
                        class="fa fa-square-o"></i> {{__('Unselect')}}</button>

                <button class="btn btn-warning lf-directory-rename d-none" data-toggle="modal"
                        data-target="#renameDirectory"><i
                        class="fa fa-pencil"></i> {{__('Rename')}}</button>
                <button class="btn btn-danger lf-directory-delete d-none" data-toggle="modal"
                        data-target="#deleteDirectory"><i
                        class="fa fa-trash"></i> {{__('Delete')}}</button>
            </div>
            <div class="col-12">
                <!-- Modal -->
                <div class="modal fade" id="uploadFile" tabindex="-1" aria-labelledby="uploadFileLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content p-4">
                            {{Form::open(['route'=>'admin.media.store','files'=>true ,'class'=>'dropzone','id'=>'my-awesome-dropzone'])}}
                            <input type="hidden" name="html-id" value="uploadFile">
                            <input type="hidden" name="path" value="{{ $pathInfo['currentPath'] }}">
                            {{Form::close()}}
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="createDirectory" tabindex="-1" aria-labelledby="createDirectoryLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content p-4">
                            {{Form::open(['route'=>'admin.directories.store'])}}
                            <input type="hidden" name="html-id" value="createDirectory">
                            <input type="hidden" name="path" value="{{ $pathInfo['currentPath'] }}">
                            <div class="form-group">
                                <label for="">{{__('Directory Name')}}</label>
                                {{Form::text('name',null,['class'=>form_validation($errors,'name')])}}
                                <span class="invalid-feedback">{{$errors->first('name')}}</span>
                            </div>

                            {{Form::submit('Create Directory',['class'=>'btn btn-block btn-success'])}}
                            {{Form::close()}}
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="renameDirectory" tabindex="-1" aria-labelledby="renameDirectoryLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content p-4">
                            {{Form::open(['route'=>'admin.directories.update','method'=>'PUT'])}}
                            <input type="hidden" name="html-id" value="renameDirectory">
                            <input type="hidden" name="path" value="{{ $pathInfo['currentPath'] }}">
                            <input type="hidden" name="old_name" value="" class="rename_field">
                            <div class="form-group">
                                <label for="">{{__('Directory Name')}}</label>
                                {{Form::text('name',null,['class'=>form_validation($errors,'name','rename_field'),])}}
                                <span class="invalid-feedback">{{$errors->first('name')}}</span>
                            </div>

                            {{Form::submit('Rename Directory',['class'=>'btn btn-block btn-success'])}}
                            {{Form::close()}}
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="deleteDirectory" tabindex="-1" aria-labelledby="deleteDirectoryLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content p-4">
                            {{Form::open(['route'=>'admin.directories.delete','method'=>'DELETE'])}}
                            <input type="hidden" name="html-id" value="deleteDirectory">
                            <input type="hidden" name="path" value="{{ $pathInfo['currentPath'] }}">
                            <input type="hidden" name="name" value="" class="delete_field">
                            <div class="form-group">
                                <label for="">{{__('Directory Name')}}</label>
                                <input class="form-control delete_field" readonly>
                            </div>

                            <p class="text-muted border-left-2 border-warning bg-grey-light p-3">{{ __('By deleting the directory, it will remove all directories and files from the directory.') }}</p>
                            {{Form::submit('Delete Directory',['class'=>'btn btn-block btn-success'])}}
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
            </div>

            {{--Directory Section--}}
            <div class="col-12">
                <div class="lf-media-folder-box mCustomScrollbar pl-0 mb-4">
                    <div class="d-flex flex-wrap">
                        @foreach($directories as $directory)
                            <div class="my-3 mx-2 text-center lf-w-100px lf-directory lf-tooltip"
                                 data-title="{{basename($directory)}}">
                                <div class="lf-checkbox d-none">
                                    <input id="{{\Illuminate\Support\Str::slug(basename($directory))}}" type="radio"
                                           value="{{basename($directory)}}" name="media_radio">
                                    <label for="{{\Illuminate\Support\Str::slug(basename($directory))}}"></label>
                                </div>
                                <a class="d-inline-block mb-2 lf-folder-link"
                                   href="{{route('admin.media.index',['directory'=>generate_media_link($pathInfo['currentPath'],basename($directory))])}}">
                                    <div class="lf-media-folder text-center d-inline-block">
                                        <i class="fa fa-folder fa-3x text-light"></i>
                                    </div>
                                </a>
                                <a class="d-block lf-folder-text-link"
                                   href="{{route('admin.media.index',['directory'=>generate_media_link($pathInfo['currentPath'],basename($directory))])}}">{{ basename($directory) }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{--Image Section--}}
            <div class="col-lg-12">
                {{ $dataTable['filters'] }}
                <div class="row my-4 media-file-list cm-lb-img-group">
                    @forelse($dataTable['items'] as $medium)
                        @include('core.media.image',['mediaId'=>$medium->id,'mediaName'=>$medium->name,'mediaPath'=>get_media_file($medium->path,$medium->file_name)])
                    @empty
                    @endforelse
                </div>
                {{ $dataTable['pagination'] }}
            </div>
        </div>
    </div>


@endsection

@section('style')
    @include('layouts.includes.list-css')
    <link rel="stylesheet" href="{{ asset('public/plugins/tipped/tipped.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/dropzon/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/cm-visual-editor/vendor/lightbox/lightbox.css') }}">
    <style>
        .lf-media-folder-box {
            max-height: 270px;
        }

        .lf-media-name {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
    </style>
@endsection

@section('script')
    @include('layouts.includes.list-js')
    <script src="{{ asset('public/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('public/plugins/dropzon/dropzone.min.js') }}"></script>
    <script src="{{ asset('public/plugins/cm-visual-editor/vendor/lightbox/lightbox.js') }}"></script>
    <script>
        (function ($) {
            'use strict';

            $(window).on("load", function () {
                $('.lf-media-folder-box').mCustomScrollbar();
            });

            $(document).on('click', '.lf-folder-link', function (e) {
                if ($('.lf-directory-select').hasClass('d-none')) {
                    e.preventDefault();
                    $(this).siblings('.lf-checkbox').children('input').trigger('click');
                }
            });

            let htmlModalId = '{{ old('html-id') }}'
            if (htmlModalId) {
                $('#' + htmlModalId).modal('show');
            }

            $(document).on('click', '.lf-directory-select', function () {
                $(this).addClass('d-none');
                $('.lf-directory-unselect').removeClass('d-none');
                $('.lf-directory .lf-checkbox').removeClass('d-none');
            });
            $(document).on('click', '.lf-directory-unselect', function () {
                $(this).addClass('d-none');
                $('.lf-directory-select').removeClass('d-none');
                $('.lf-directory .lf-checkbox').addClass('d-none');

                $('.lf-directory-rename').addClass('d-none');
                $('.lf-directory-delete').addClass('d-none');
                $('.lf-checkbox input').prop('checked', false)

            });
            $(document).on('change', '.lf-checkbox input', function () {
                $('.lf-directory-rename').removeClass('d-none');
                $('.lf-directory-delete').removeClass('d-none');
                $('.rename_field').val($(this).val());
                $('.delete_field').val($(this).val());
            });
            var clipboard = new ClipboardJS('.btn');

            clipboard.on('success', function (e) {
                lfToaster($(e.trigger), 'Copied');
                e.clearSelection();
            });

            Dropzone.options.myAwesomeDropzone = {
                queuecomplete: function (file) {
                },
                success: function (file, response) {
                    let total = $('.media-file-list').children();
                    if (total.length > 9) {
                        for (let x = 9; x < total.length; x++) {
                            $('.media-file-list').children().eq(x).remove()
                        }
                    }
                    $('.media-file-list').prepend(response.data.html)
                }
            };
        })(jQuery);
    </script>
@endsection
