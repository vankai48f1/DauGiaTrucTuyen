@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                @include('seller.auction._auction_nav')
                <!-- Start: comment section -->
                <div class="m-t-50">
                    <!-- Start: total comment -->
                    <div class="single-comment-amount color-default mb-4">
                        {{__('Comments')}}
                    </div>
                    <!-- End: total comment -->

                    <!-- Start: single comment -->
                    @if(count($dataTables['items']) > 0)
                        @include('layouts.includes.comment_index')
                    @else
                        <span class="color-666">
                            <h6><i class="fa fa-comment-o"></i> {{('No Comment Available')}}</h6>
                        </span>
                    @endif
                    <!-- End: single comment -->

                    <!-- Start: total comment -->
                    <div class="single-comment-amount text-capitalize color-default mt-3 mb-4">
                        {{__('add comment')}}
                    </div>
                    <!-- End: total comment -->
                    @auth
                    <!-- Start: comment form -->
                    @include('layouts.includes.comment_form')
                    <!-- Start: comment form -->
                    @endauth

                    @guest
                        <a class="btn btn-info" href="{{ route('login') }}">{{ __('Login to Comment') }}</a>
                    @endguest
                </div>
                <!-- End: comment section -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="commentModalCenter" tabindex="-1" role="dialog" aria-labelledby="commentModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{__('Replay Comment')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" id="replay-comment" class="cvalidate" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-12">
                                {{ Form::textarea('content', null, ['class' => 'form-control color-666', 'id' => 'content','placeholder' => __('Comment'), 'rows' => 3]) }}
                                <span class="invalid-feedback" data-name="content">{{ $errors->first('content') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" class="btn btn-sm btn-primary form-submission-button">{{__('Submit')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('style')
    @include('layouts.includes.list-css')
@endsection

@section('script')
    @include('layouts.includes.list-js')
    <script src="{{asset('public/plugins/cvalidator/cvalidator-language-en.js')}}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator.js')}}"></script>
    <script>
        "use strict";

        $(document).ready(function () {
            $('#replay-comment').cValidate({
                rules : {
                    'content' : 'required|min:3|max:555',
                }
            });

            $('#parentComment').cValidate({
                rules : {
                    'content' : 'required|min:3|max:555',
                }
            });

            $(document).find('.replay-btn').on('click', function (e) {
                $(document).find('#replay-comment').attr('action', $(this).data('url'));
            });
        });
    </script>
@endsection
