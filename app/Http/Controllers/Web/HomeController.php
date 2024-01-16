<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Core\Page;
use App\Models\User\Auction;
use App\Services\Core\DataTableService;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function __invoke(): View
    {
        $homePage = Page::whereNotNull('published_at')->where('is_home_page', ACTIVE)->first();

        if($homePage){
            $data['page'] = $homePage;
            return view('core.pages.show', $data);
        }

        return view('regular_pages.home');
    }

}
