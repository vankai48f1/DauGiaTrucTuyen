<?php

use App\Models\User\Auction;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

if (!function_exists('short_code_blog_list')) {
    function short_code_blog_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'column' => 'required|integer',
            'item' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return '';
        }
        $validateData = $validator->validate();

        $blogs = collect([]);
        $faker = Factory::create();
        for ($x = 0; $x < $validateData['item']; $x++) {
            $blogs->push([
                'title' => $faker->sentence,
                'body' => $faker->paragraphs(3, true)
            ]);
        }

        $html = '<div class="row">';
        foreach ($blogs as $blog) {
            $html .= '<div class="col-md-' . (12 / $validateData['column']) . '">
                  <div class="mb-4 shadow-sm border">
                    <div class="post-thumbnail"><img src="' . get_image_placeholder(100, 80, 20) . '" alt="thumbnail" class="img-fluid"></div>
                    <div class="post-content p-3">
                    <h5 class="font-weight-bold"><a href="#">' . $blog['title'] . '</a></h5>
                      <p class="card-text">' . Str::limit($blog['body'], 50) . '</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <a href="#" class="btn btn-sm btn-secondary">View</a>
                          <a href="#" class="btn btn-sm btn-outline-secondary">Edit</a>
                        </div>
                        <small class="text-muted">9m</small>
                      </div>
                    </div>
                  </div>
                </div>';
        }
        $html .= '</div>';
        return $html;
    }
}

if (!function_exists('short_code_auction_list')) {
    function short_code_auction_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'column' => 'required|integer',
            'item' => 'required|integer',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return '';
        }
        $validateData = $validator->validate();
        $auctions = Auction::where('status', AUCTION_STATUS_RUNNING)
            ->when($request->has('type'), function ($query) use ($validateData) {
                if ($validateData['type'] == 'popular') {
                    $query->withCount('bids')->orderBy('bids_count', 'desc');
                } else {
                    $query->orderBy('created_at', 'desc');
                }
            })
            ->with('seller.user.profile')
            ->limit($validateData['item'])
            ->get();


        $html = '<div class="row">';
        if ($auctions->isNotEmpty()){
            foreach ($auctions as $auction) {
                $html .= view('layouts.includes.auction-card', ['auction' => $auction, 'column' => $validateData['column']])->render();
            }
        }
        else {
            $html .= '<div class="col-12"><div class="text-center bg-custom-gray p-3">'. __('No auction available!') .'</div></div>';
        }

        $html .= '</div>';
        return $html;
    }
}


