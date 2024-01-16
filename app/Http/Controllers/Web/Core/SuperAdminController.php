<?php

namespace App\Http\Controllers\Web\Core;


use App\Http\Controllers\Controller;
use App\Services\Core\UserService;
use Codemen\Installer\{Requests\FormRequest, Services\FormGenerator};
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SuperAdminController extends Controller
{

    public function view($type, $routeConfig): View
    {
        $route = route('installer.types.store', $type);
        $form = app(FormGenerator::class)->generate($routeConfig['fields'], $route);
        $title = __('Super Admin Configuration');
        return view('vendor.installer.environment',
            compact(
                'type',
                'routeConfig',
                'form',
                'title'
            )
        );
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $routeConfig = $request->getRouteConfig();
        $params = $request->validated();
        $params['is_email_verified'] = ACTIVE;
        $params['is_financial_active'] = ACTIVE;
        $params['is_accessible_under_maintenance'] = ACTIVE;
        $params['is_active'] = ACTIVE;
        $params['is_super_admin'] = ACTIVE;
        $params['assigned_role'] = USER_ROLE_ADMIN;
        try {
            app(UserService::class)->generate($params);
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route($routeConfig['next_route']['name'], $routeConfig['next_route']['parameters']);
    }

}

