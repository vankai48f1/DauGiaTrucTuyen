<?php

namespace App\Http\Controllers\Web\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\NavigationRequest;
use App\Models\Core\Page;
use App\Services\Core\NavigationService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NavigationController extends Controller
{
    private $navigationService;

    public function __construct(NavigationService $navigationService)
    {
        $this->navigationService = $navigationService;
    }

    public function index(string $slug = 'top-nav'): View
    {
        $data = $this->navigationService->backendMenuBuilder($slug);
        $data['title'] = __('Navigation');
        $data['slug'] = $slug;
        $data['pages'] = Page::whereNotNull('published_at')->get();

        return view('core.navigation.index', $data);
    }

    public function save(NavigationRequest $request, string $slug)
    {
        $response = $this->navigationService->backendMenuSave($request, $slug);
        $status = $response[RESPONSE_STATUS_KEY] ? RESPONSE_TYPE_SUCCESS : RESPONSE_TYPE_ERROR;

        return redirect()
            ->route('menu-manager.index', $slug)
            ->with($status, $response[RESPONSE_MESSAGE_KEY]);
    }
}
