<?php

namespace App\Http\Controllers\Web\Core;


use App\Http\Controllers\Controller;
use App\Services\Core\UserService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Codemen\Installer\{Requests\FormRequest, Services\EnvironmentManager, Services\FormGenerator};
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DatabaseController extends Controller
{

    public function view($type, $routeConfig): View
    {
        $storeRouteName = route('installer.types.store', $type);
        $form = app(FormGenerator::class)->generate($routeConfig['fields'], $storeRouteName);
        $title = ucwords(str_replace('-', ' ', $type));
        return view('vendor.installer.environment',
            compact(
                'type',
                'routeConfig',
                'storeRouteName',
                'form',
                'title'
            )
        );
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $routeConfig = $request->getRouteConfig();
        $variables = $request->validated();
        app(EnvironmentManager::class)->save($variables);
        $databaseFile = file_get_contents(base_path("database/database.sql"));

        Config::set('database.connections.installer', array(
            'driver' => $variables['db_connection'],
            'host' => $variables['db_host'],
            'port' => $variables['db_port'],
            'database' => $variables['db_database'],
            'username' => $variables['db_username'],
            'password' => $variables['db_password'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ));

        DB::setDefaultConnection('installer');
        DB::unprepared($databaseFile);

        return redirect()->route($routeConfig['next_route']['name'], $routeConfig['next_route']['parameters']);
    }

}

