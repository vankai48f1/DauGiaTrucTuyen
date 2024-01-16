<?php

namespace App\Providers;

use App\Models\Auction\Currency;
use App\Models\User\KnowYourCustomer;
use App\Models\User\Wallet;
use App\Models\User\WalletTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = '';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('wallet', function ($value, $route) {
            if (is_numeric($value)) {
                return Wallet::where('id', $value)
                    ->when($route->parameter('user'), function ($query) use ($route) {
                        $query->where('user_id', $route->parameter('user'));
                    })->firstOrFail();
            } elseif (Auth::check()) {
                return Wallet::where('user_id', Auth::id())
                    ->where('currency_symbol', $value)
                    ->when($route->parameter('user'), function ($query) use ($route) {
                        $query->where('user_id', $route->parameter('user'));
                    })->firstOrFail();
            }
        });

        Route::bind('deposit', function ($value, $route) {
            return WalletTransaction::where('id', $value)
                ->where('txn_type', TRANSACTION_TYPE_DEPOSIT)
                ->when($route->parameter('wallet'), function ($query) use ($route) {
                    $query->where('wallet_id', $route->parameter('wallet')->id);
                })
                ->when($route->parameter('user'), function ($query) use ($route) {
                    $query->where('user_id', $route->parameter('user'));
                }, function ($query) {
                    if( !auth()->user()->is_super_admin ) {
                        $query->where('user_id', \auth()->id());
                    }
                })
                ->firstOrFail();
        });
        Route::bind('currency', function ($value, $route) {
            return Currency::where('symbol', $value)
                ->firstOrFail();
        });
        Route::pattern('id', '[0-9]+');
        Route::pattern('admin_setting_type', implode('|', array_keys(config('appsettings'))));
        Route::pattern('menu_slug', implode('|', config('navigation.registered_place')));
        Route::model('kyc_verification', KnowYourCustomer::class);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapPermissionApiRoutes();
        $this->mapVerificationPermissionApiRoutes();
        $this->mapGuestPermissionApiRoutes();
        $this->mapApiRoutes();

        $this->mapPermissionRoutes();
        $this->mapVerificationPermissionRoutes();
        $this->mapGuestPermissionRoutes();
        $this->mapWebRoutes();
    }

    protected function mapPermissionApiRoutes()
    {
        $filename = 'permission_api';
        $middleware = ['api', 'auth:sanctum', 'permission.api'];
        $prefix = 'api';
        $namespace = null;
        $this->routeMap($filename, $middleware, $prefix, $namespace);
    }

    protected function routeMap($filename, $middleware, $prefix = null, $namespace = null, $path = 'routes/groups/')
    {
        $locale = strtolower($this->app->request->segment(1));
        $language = check_language($locale);
        if ($language != null && $prefix != null) {
            $prefix = $language . '/' . $prefix;
        } elseif ($language != null) {
            $prefix = $language;
        }

        if ($namespace != null) {
            $namespace = $this->namespace . '\\' . ucfirst($namespace);
        } else {
            $namespace = $this->namespace;
        }

        Route::prefix($prefix)
            ->middleware($middleware)
            ->namespace($namespace)
            ->group(base_path($path . $filename . '.php'));
    }

    protected function mapVerificationPermissionApiRoutes()
    {
        $filename = 'verification_permission_api';
        $middleware = ['api', 'verification.permission.api'];
        $prefix = 'api';
        $namespace = null;
        $this->routeMap($filename, $middleware, $prefix, $namespace);
    }

    protected function mapGuestPermissionApiRoutes()
    {
        $filename = 'guest_permission_api';
        $middleware = ['api', 'guest.permission.api'];
        $prefix = 'api';
        $namespace = null;
        $this->routeMap($filename, $middleware, $prefix, $namespace);
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    // API Starts here

    protected function mapPermissionRoutes()
    {
        $filename = 'permission';
        $middleware = ['web', 'auth', 'permission'];
        $prefix = $namespace = null;
        $this->routeMap($filename, $middleware, $prefix, $namespace);
    }

    protected function mapVerificationPermissionRoutes()
    {
        $filename = 'verification_permission';
        $middleware = ['web', 'verification.permission'];
        $prefix = $namespace = null;
        $this->routeMap($filename, $middleware, $prefix, $namespace);
    }

    protected function mapGuestPermissionRoutes()
    {
        $filename = 'guest_permission';
        $middleware = ['web', 'guest.permission'];
        $prefix = $namespace = null;
        $this->routeMap($filename, $middleware, $prefix, $namespace);
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */

    protected function mapWebRoutes()
    {
        $filename = $middleware = 'web';
        $middleware = ['web', 'menuable'];
        $prefix = $namespace = null;
        $this->routeMap($filename, $middleware, $prefix, $namespace, 'routes/');
    }
}
