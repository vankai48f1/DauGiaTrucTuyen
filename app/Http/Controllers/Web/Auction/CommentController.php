<?php

namespace App\Http\Controllers\Web\Auction;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CommentRequest;
use App\Models\Core\Notification;
use App\Models\User\Auction;
use App\Models\User\Comment;
use App\Models\User\Seller;
use App\Services\Core\DataTableService;

class CommentController extends Controller
{
    public function index(Auction $auction)
    {
        $data['title'] = __('Auction Comments');
        $data['auction'] = $auction;

        if( $auction->status == AUCTION_STATUS_COMPLETED && auth()->check() ) {
            $data['winner'] = $auction->getWinner()
                ->where('user_id', auth()->id())
                ->first();
        }

        $queryBuilder = $auction->comments()
            ->with('user.profile', 'childComments.user.profile')
            ->orderByDesc('created_at');
        $data['dataTables'] = app(DataTableService::class)
            ->withoutDateFilter()
            ->create($queryBuilder);

        return view('auction.comments', $data);
    }

    public function store(CommentRequest $request, $auctionId)
    {
        $parameters = $request->only('content');
        $parameters['user_id'] = auth()->user()->id;
        $parameters['auction_id'] = $auctionId;

        $comment = Comment::create($parameters);

        $userName = auth()->user()->username;
        $auction = Auction::where('id', $auctionId)->first();
        $auctionCreator = Seller::where('id', $auction->seller_id)->first();
        $route = route('auction.show', $auction->ref_id);

        $commentNotifications = [
            'user_id' => $auctionCreator->id,
            'message' => __("<strong>:username</strong> commented on your auction <strong>:auction</strong>", ['username' => $userName, 'auction' => $auction->title]),
            'link' => $route,
        ];

        $notification = Notification::create($commentNotifications);

        if (!empty($comment) && !empty($notification)) {
            return redirect()->route('auction.comments', $auction->ref_id)->with(RESPONSE_TYPE_SUCCESS, __('Comment has been submitted successfully'));
        }

        return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Failed to submit the comment'));

    }

    public function reply(CommentRequest $request, $auctionId, $comment)
    {
        $comment = Comment::where('id', $comment)
            ->where('auction_id', $auctionId)
            ->with('auction')
            ->first();

        if ($comment) {
            $attributes = [
                'user_id' => auth()->id(),
                'auction_id' => $auctionId,
                'content' => $request->get('content')
            ];

            $attributes['comment_id'] = !is_null($comment->commnet_id) ? $comment->commnet_id : $comment->id;

            if (Comment::create($attributes)) {
                return redirect()
                    ->route('auction.comments', $comment->auction->ref_id)
                    ->with(RESPONSE_TYPE_SUCCESS, __('The comment has been created successfully.'));
            }
        }

        return redirect()
            ->back()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to reply the comment.'));
    }
}
