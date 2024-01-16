<?php

namespace App\Http\Controllers\Web\Page;

use App\Http\Controllers\Controller;
use App\Models\Core\Page;

class PageController extends Controller
{
    public function __invoke(Page $page)
    {
        abort_if((empty($page->published_at) || $page->is_home_page), 404);

        $data['page'] = $page;
        return view('core.pages.show', $data);
    }
}
