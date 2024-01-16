<!-- Start: single comment -->
@forelse($dataTables['items']->sortBy('created_at') as $comment)
    <div class="single-comment position-relative mb-3">
        <div class="media">

            <!-- Start: media image -->
            <img class="mr-3 img-fluid" src="{{get_avatar($comment->user->avatar)}}" alt="image">
            <!-- End: media image -->

            <!-- Start: media body -->
            <div class="media-body">

                <div class="single-comment-bg">
                    <!-- Start: name and date -->
                    <span class="mb-1 d-inline-block comment-title">{{$comment->user->profile->full_name}}</span>
                    <a type="button" class="color-default replay-btn float-right" data-toggle="modal" data-url="{{route('comment.reply', ['auctionId' => $auction->id, 'comment' => $comment->id])}}" data-target="#commentModalCenter">
                        <i class="fa fa-reply"></i> {{__('Replay')}}
                    </a>
                    <!-- End: name and date -->

                    <!-- Start: comment -->
                    <p class="color-999 fz-12 mt-2 text-justify mb-0">{{$comment->content}}</p>
                    <!-- End: comment -->

                    <p class="sub-text text-right mb-0">{{ $comment->created_at->diffForHumans() }}</p>
                </div>

                @if(!empty($comment->childComments))
                    @foreach($comment->childComments->sortBy('created_at') as $childComment)
                        <div class="media single-comment mt-3">

                            <!-- Start: media image -->
                            <img class="mr-3 img-fluid" src="{{get_avatar($childComment->user->avatar)}}" alt="image">
                            <!-- End: media image -->

                            <!-- Start: media body -->
                            <div class="media-body single-comment-bg">

                                <!-- Start: name and date -->
                                <span class="mb-1 d-inline-block comment-title">{{$childComment->user->profile->full_name}}</span>
                                <!-- End: name and date -->
                                <a type="button" class="color-default replay-btn float-right" data-toggle="modal" data-url="{{route('comment.reply', ['auctionId' => $auction->id, 'comment' => $comment->id])}}" data-target="#commentModalCenter">
                                    <i class="fa fa-reply"></i> {{__('Replay')}}
                                </a>

                                <!-- Start: comment -->
                                <p class="color-999 fz-12 mt-2 text-justify mb-0">{{$childComment->content}}</p>
                                <!-- End: comment -->

                                <p class="sub-text text-right mb-0">{{ $childComment->created_at->diffForHumans() }}</p>

                            </div>
                            <!-- Start: media body -->

                        </div>
                    @endforeach
                @endif

            </div>
            <!-- Start: media body -->

        </div>
    </div>
    @empty
    <div class="bg-custom-gray p-3 text-center">
        {{ __('No comments yet!') }}
    </div>
@endforelse

{{ $dataTables['pagination'] }}
<!-- End: single comment -->
