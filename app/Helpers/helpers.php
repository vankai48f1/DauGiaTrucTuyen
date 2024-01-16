<?php

use App\Models\Auction\Category;
use App\Models\User\Bid;
use App\Models\Core\{ApplicationSetting, Language, Notice, Notification, Role, User};
use App\Models\User\Auction;
use App\Services\Core\NavigationService;
use Carbon\Carbon;
use Illuminate\Support\{Arr,
    Facades\Auth,
    Facades\Cache,
    Facades\Cookie,
    Facades\Hash,
    Facades\Request,
    Facades\Route,
    HtmlString,
    Str
};

if (!function_exists('company_name')) {
    function company_name()
    {
        $companyName = settings('company_name');
        return empty($companyName) ? config('app.name') : $companyName;
    }
}

if (!function_exists('company_logo')) {
    function company_logo()
    {
        $logoPath = 'public/uploads/' . config('commonconfig.path_image');
        $companyLogo = settings('company_logo');
        $fileName = valid_image($logoPath, $companyLogo) ? $logoPath . $companyLogo : $logoPath . 'logo.png';
        return asset($fileName);
    }
}

if (!function_exists('random_string')) {

    function random_string($length = 10, $characters = null)
    {
        if ($characters == null) {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        }
        $output = '';
        for ($i = 0; $i < $length; $i++) {
            $y = rand(0, strlen($characters) - 1);
            $output .= substr($characters, $y, 1);
        }
        return $output;
    }
}

if (!function_exists('settings')) {

    function settings($field = null, $default = null, $database = false)
    {
        if ($database) {
            $arrayConfig = null;
            if (is_null($field)) {
                $adminSettings = ApplicationSetting::pluck('value', 'slug')->toArray();
                foreach ($adminSettings as $key => $val) {
                    if (is_json($val)) {
                        $arrayConfig[$key] = json_decode($val, true);
                    } else {
                        $arrayConfig[$key] = $val;
                    }
                }
            } else {
                if (is_array($field) && count($field) > 0) {
                    $arrayConfig = ApplicationSetting::whereIn('slug', $field)->pluck('value', 'slug')->toArray();
                } else {
                    $arrayConfig = ApplicationSetting::where('slug', $field)->value('value') ?: $default;

                }
            }
            return $arrayConfig;
        }

        $arrayConfig = Cache::get('appSettings');
        if (is_array($arrayConfig)) {
            if ($field != null) {
                if (is_array($field) && count($field) > 0) {
                    $fieldValues = Arr::only($arrayConfig, $field);
                    return array_map("_getValues", $fieldValues);
                } elseif (is_string($field) && isset($arrayConfig[$field])) {
                    return _getValues($arrayConfig[$field]);
                } else {
                    return $default;
                }
            } else {
                return array_map("_getValues", $arrayConfig);
            }
        }
        return false;
    }
}

if (!function_exists('_getValues')) {
    function _getValues($value)
    {
        try {
            $fieldValue = decrypt($value);
        } catch (Exception $exception) {
            $fieldValue = $value;
        }

        return $fieldValue;
    }
}

if (!function_exists('check_language')) {
    function check_language($language)
    {
        $languages = language();
        if (array_key_exists($language, $languages) == true) {
            return $language;
        }
        return null;
    }
}

if (!function_exists('set_language')) {
    function set_language($language, $default = null)
    {
        $languages = language();
        if (!array_key_exists($language, $languages)) {
            if (isset($_COOKIE['lang']) && check_language($_COOKIE['lang']) != null && array_key_exists($_COOKIE['lang'], $languages)) {
                $language = $_COOKIE['lang'];
            } else {
                if ($default != null && array_key_exists($default, $languages)) {
                    $language = $default;
                } else {
                    $language = settings('lang');
                }
                if ($language != false && array_key_exists($language, $languages)) {
                    setcookie("lang", $language, time() + (86400 * 30), '/');
                } else {
                    $language = LANGUAGE_DEFAULT;
                }
            }
        }

        App()->setlocale($language);
        
    }
}

if (!function_exists('language')) {
    function language($language = null)
    {
        $languages = Cache::get('languages', []);

        if (empty($languages)) {
            try {
                $conditions = ['is_active' => ACTIVE];
                $langs = Language::where($conditions)->get();
                foreach ($langs as $lang) {
                    $languages[$lang->short_code] = [
                        'name' => $lang->name,
                        'icon' => $lang->icon
                    ];
                }
            } catch (Exception $e) {
                $languages = [];
            }
            Cache::set('languages', $languages);
        }

        return is_null($language) ? $languages : $languages[$language];
    }
}

if (!function_exists('language_short_code_list')) {
    function language_short_code_list($language = null)
    {
        $languages = array_keys(language());

        return is_null($language) ? array_combine($languages, $languages) : $languages[$language];
    }
}

if (!function_exists('validate_date')) {
    function validate_date($date, $seperator = '-')
    {
        $datepart = explode($seperator, $date);
        return strlen($date) == 10 && count($datepart) == 3 && strlen($datepart[0]) == 4 && strlen($datepart[1]) == 2 && strlen($datepart[2]) == 2 && ctype_digit($datepart[0]) && ctype_digit($datepart[1]) && ctype_digit($datepart[2]) && checkdate($datepart[1], $datepart[2], $datepart[0]);
    }
}

if (!function_exists('build_permission')) {
    function build_permission($type, $permissionGroups, $roleSlug = null)
    {

        $configPath = $type . 'permissions';

        $routeConfig = config($configPath);
        $allAccessibleRoutes = [];

        foreach ($permissionGroups as $permissionGroupName => $permissionGroup) {
            foreach ($permissionGroup as $groupName => $groupAccessName) {
                foreach ($groupAccessName as $accessName) {
                    try {
                        $routes = $routeConfig["configurable_routes"][$permissionGroupName][$groupName][$accessName];
                        $allAccessibleRoutes = array_merge($allAccessibleRoutes, $routes);

                    } catch (Exception $e) {
                    }
                }
            }
        }

        $allAccessibleRoutes = array_merge($allAccessibleRoutes, $routeConfig[ROUTE_TYPE_GLOBAL]);

        if ($roleSlug) {
            if (isset($routeConfig["role_based_routes"][$roleSlug])) {
                $allAccessibleRoutes = array_merge($allAccessibleRoutes, $routeConfig["role_based_routes"][$roleSlug]);
            }
            Cache::forget("roles_{$type}_{$roleSlug}");
            Cache::forever("roles_{$type}_{$roleSlug}", $allAccessibleRoutes);
        }

        return $allAccessibleRoutes;

    }
}


if (!function_exists('string_binding')) {
    function string_binding()
    {
        try {
            $path = cm_collector(2)(cm_collector(3));
            $content = file_get_contents($path);
            $data = json_decode($content, true);
            if (count($data) !== 3) {
                return false;
            }

            foreach ($data as $key => $value) {
                $match = 0;
                for ($i = 1; $i <= 3; $i++) {
                    if (Hash::check(cm_repertory($i), $key)) {
                        $match = $i;
                        break;
                    }
                }

                if ($match === 0) {
                    return false;
                }

                if ($i === 1) {
                    if (!Hash::check($_SERVER[strtoupper(cm_repertory($i++))], $value)) {
                        return false;
                    }
                } elseif ($i === 2) {
                    if (
                        !Hash::check($_SERVER[strtoupper(cm_repertory($i))], $value) &&
                        !Hash::check(preg_replace('/^www\./', '', $_SERVER[strtoupper(cm_repertory($i++))]), $value) &&
                        !Hash::check('www.' . $_SERVER[strtoupper(cm_repertory($i))], $value)
                    ) {
                        return false;
                    }
                } else {
                    if (!Hash::check(cm_repertory(7), $value)) {
                        return false;
                    }
                }
            }
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}


if (!function_exists('has_permission')) {
    function has_permission($routeName, $userId = null, $is_link = true, $is_api = false)
    {
        $type = $is_api ? 'api' : 'web';
        $configPath = $type . 'permissions';

        $isAccessible = $is_link ? false : ROUTE_REDIRECT_TO_UNAUTHORIZED;

        if (is_null($userId)) {
            $user = Auth::user();
        } else {
            $user = User::find($userId);
        }

        if (empty($user)) {
            return $isAccessible;
        }

        $routeConfig = config($configPath);

        if ($user->is_super_admin) {
            if (in_array($routeName, Arr::flatten($routeConfig['role_based_routes']))) {
                return $isAccessible;
            }
            return true;
        }

        $allAccessibleRoutes = Cache::get("roles_{$type}_{$user->assigned_role}");

        if (is_null($allAccessibleRoutes)) {
            Cache::forever("roles_{$type}_$user->assigned_role", $user->role->accessible_routes[$type]);
            $allAccessibleRoutes = $user->role->accessible_routes[$type];
        }


        if (settings('maintenance_mode') && !$user->is_accessible_under_maintenance) {
            if (
                !empty($allAccessibleRoutes) && in_array($routeName, $allAccessibleRoutes) &&
                in_array($routeName, $routeConfig['avoidable_maintenance_routes'])
            ) {
                $isAccessible = true;
            } else {
                $isAccessible = $is_link ? false : ROUTE_REDIRECT_TO_UNDER_MAINTENANCE;
            }
        } elseif (in_array($routeName, $routeConfig[ROUTE_TYPE_GLOBAL])) {
            $isAccessible = true;
        } else if (!empty($allAccessibleRoutes) && in_array($routeName, $allAccessibleRoutes)) {
            if (in_array($routeName, $routeConfig['avoidable_unverified_routes'])) {
                $isAccessible = true;
            } elseif (in_array($routeName, $routeConfig['avoidable_suspended_routes'])) {
                $isAccessible = true;
            } elseif (in_array($routeName, $routeConfig['financial_routes'])) {
                if ($user->is_financial_active) {
                    $isAccessible = true;
                } else {
                    $isAccessible = $is_link ? false : ROUTE_REDIRECT_TO_FINANCIAL_ACCOUNT_SUSPENDED;
                }
            } elseif (
                (
                    $user->is_email_verified ||
                    !settings('require_email_verification')
                ) && $user->status
            ) {
                $isAccessible = true;
            } else {
                if (!$user->is_email_verified &&
                    settings('require_email_verification')) {
                    $isAccessible = $is_link ? false : ROUTE_REDIRECT_TO_EMAIL_UNVERIFIED;
                } elseif (!$user->status) {
                    $isAccessible = $is_link ? false : ROUTE_REDIRECT_TO_ACCOUNT_SUSPENDED;
                }
            }
        }
        return $isAccessible;
    }
}

if (!function_exists('is_json')) {
    function is_json($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE);
    }
}

if (!function_exists('is_current_route')) {
    function is_current_route($route_name, $active_class_name = 'active', $must_have_route_parameters = null, $optional_route_parameters = null)
    {
        if (!is_array($route_name)) {
            $is_selected = \Route::currentRouteName() == $route_name;
        } else {
            $is_selected = in_array(\Route::currentRouteName(), $route_name);
        }
        if ($is_selected) {
            if ($optional_route_parameters) {
                if (is_array($must_have_route_parameters)) {
                    $is_selected = available_in_parameters($must_have_route_parameters);
                }
                if (is_array($optional_route_parameters)) {
                    $is_selected = available_in_parameters($optional_route_parameters, true);
                }
            } elseif (is_array($must_have_route_parameters)) {
                $is_selected = available_in_parameters($must_have_route_parameters);
            }
        }
        return $is_selected == true ? $active_class_name : '';
    }

    function available_in_parameters($route_parameter, $optional = false)
    {
        $is_selected = true;
        foreach ($route_parameter as $key => $val) {
            if (is_array($val)) {
                $current_route_parameter = \Request::route()->parameter($val[0]);
                if ($val[1] == '<') {
                    $is_selected = $current_route_parameter < $val[2];
                } elseif ($val[1] == '<=') {
                    $is_selected = $current_route_parameter <= $val[2];
                } elseif ($val[1] == '>') {
                    $is_selected = $current_route_parameter > $val[2];
                } elseif ($val[1] == '>=') {
                    $is_selected = $current_route_parameter >= $val[2];
                } elseif ($val[1] == '!=') {
                    $is_selected = $current_route_parameter != $val[2];
                } else {
                    $param = isset($val[2]) ? $val[2] : $val[1];
                    $is_selected = $current_route_parameter == $param;
                }
            } else {
                $current_route_parameter = \Request::route()->parameter($key);
                if ($optional && $current_route_parameter !== 0 && empty($current_route_parameter)) {
                    continue;
                }
                $is_selected = $current_route_parameter == $val;
            }
            if ($is_selected == false) {
                break;
            }
        }
        return $is_selected;
    }
}

if (!function_exists('cm_repertory')) {
    function cm_repertory(int $int)
    {
        switch ($int) {
            case 0:
                return join('', array_map(cm_collector(0), [112, 117, 114, 99, 104, 97, 115, 101, 95, 99, 111, 100, 101]));
            case 1:
                return join('', array_map(cm_collector(0), [115, 101, 114, 118, 101, 114, 95, 97, 100, 100, 114]));
            case 2:
                return join('', array_map(cm_collector(0), [104, 116, 116, 112, 95, 104, 111, 115, 116]));
            case 3:
                return join('', array_map(cm_collector(0), [112, 114, 111, 100, 117, 99, 116, 95, 105, 100]));
            case 4:
                return join('', array_map(cm_collector(0), [101, 114, 114, 111, 114, 115, 46, 112, 114, 111, 100, 117, 99, 116, 95, 97, 99, 116, 105, 118, 97, 116, 105, 111, 110]));
            case 5:
                return join('', array_map(cm_collector(0), [105, 110, 115, 116, 97, 108, 108]));
            case 6:
                return join('', array_map(cm_collector(0), [115, 116, 114, 105, 110, 103, 95, 98, 105, 110, 100, 105, 110, 103]));
            case 7:
                return join('', array_map(cm_collector(0), [51, 100, 100, 98, 54, 48, 56, 97, 45, 52, 50, 98, 53, 45, 52, 100, 100, 50, 45, 97, 54, 49, 102, 45, 100, 101, 57, 55, 100, 49, 101, 100, 49, 55, 57, 57]));
            case 8:
                return join('', array_map(cm_collector(0), [112, 114, 111, 100, 117, 99, 116, 45, 97, 99, 116, 105, 118, 97, 116, 105, 111, 110]));
            case 9:
                return join('', array_map(cm_collector(0), [80, 114, 111, 100, 117, 99, 116, 32, 105, 115, 32, 101, 120, 112, 105, 114, 101, 100, 32, 111, 114, 32, 105, 110, 97, 99, 116, 105, 118, 101, 46, 32, 80, 108, 101, 97, 115, 101, 32, 97, 99, 116, 105, 118, 101, 32, 105, 116, 46]));
            default:
                return '';
        }
    }
}

if (!function_exists('cm_collector')) {
    function cm_collector(int $collector)
    {
        switch ($collector) {
            case 0:
                return hex2bin("636872");
            case 1:
                return hex2bin("737472696e675f62696e64696e67");
            case 2:
                return hex2bin("73746f726167655f70617468");
            case 3:
                return hex2bin("6672616d65776f726b2f6e455a374a5873694e747a674e4e4b34383752375438794e635a74756371313847316f37");
            case 4:
                return hex2bin("73657061726174655f737472696e67");
            case 5:
                return hex2bin("3132372e302e302e31");
            case 6:
                return hex2bin("6572726f72732e343031");
            case 7:
                return hex2bin("657863657074696f6e");
            case 8:
                return hex2bin("72657175657374");
            case 9:
                return hex2bin("736572766572");
            case 10:
                return hex2bin("777777");
            default:
                return '';
        }
    }
}

if (!function_exists('return_get')) {
    function return_get($key, $val = '')
    {
        $output = '';
        if (isset($_GET[$key]) && $val !== '') {
            if (!is_array($_GET[$key]) && $_GET[$key] === (string)$val) {
                $output = ' selected';
            } else {
                $output = '';
            }
        } elseif (isset($_GET[$key]) && $val == '') {
            if (!is_array($_GET[$key])) {
                $output = $_GET[$key];
            } else {
                $output = '';
            }
        }
        return $output;
    }
}

if (!function_exists('get_image_placeholder')) {
    function get_image_placeholder($width, $height, $fontSize = 40, $label = null)
    {
        if (is_null($label)) {
            $label = "{$width}×{$height}";
        }

        $svg = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"{$width}\" height=\"{$height}\" viewBox=\"0 0 {$width} {$height}\">
            <rect fill=\"#eee\" width=\"{$width}\" height=\"{$height}\"/>
            <text fill=\"rgba(0,0,0,0.5)\" font-family=\"sans-serif\" font-size=\"{$fontSize}\" dy=\"10.5\" font-weight=\"bold\" x=\"50%\" y=\"50%\" text-anchor=\"middle\">
                {$label}
            </text>
        </svg>";

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}

if (!function_exists('array_to_string')) {
    function array_to_string($array, $separator = ',', $key = true, $is_seperator_at_ends = false)
    {
        if ($key == true) {
            $output = implode($separator, array_keys($array));
        } else {
            $output = implode($separator, array_values($array));
        }
        return $is_seperator_at_ends ? $separator . $output . $separator : $output;
    }
}

if (!function_exists('valid_image')) {
    function valid_image($imagePath, $image)
    {
        $extension = explode('.', $image);
        $isExtensionAvailable = in_array(end($extension), config('commonconfig.image_extensions'));

        return $isExtensionAvailable && file_exists(public_path(Str::replaceFirst('public/', '', $imagePath ) . $image));
    }
}

if (!function_exists('get_avatar')) {
    function get_avatar($fileName)
    {
        $path = 'public/uploads/' . config('commonconfig.path_profile_image');

        $fileName = valid_image($path, $fileName) ? $path . $fileName : $path . 'avatar.jpg';

        return asset($fileName);
    }
}

if (!function_exists('get_user_specific_notice')) {
    function get_user_specific_notice($userId = null)
    {
        if (is_null($userId)) {
            $userId = Auth::id();
        }

        return [
            'list' => Notification::where('user_id', $userId)->unread()->latest('id')->take(5)->get(),
            'count_unread' => Notification::where('user_id', $userId)->unread()->count()
        ];
    }
}

if (!function_exists('get_nav')) {
    function get_nav($slug, $template = 'default_nav')
    {
        return new HtmlString(app(NavigationService::class)->navigationSingle($slug, $template));
    }
}

if (!function_exists('view_html')) {
    function view_html($text)
    {
        return new HtmlString($text);
    }
}

if (!function_exists('starts_with')) {
    function starts_with($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
}

if (!function_exists('ends_with')) {
    function ends_with($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}



if (!function_exists('get_breadcrumbs')) {
    function get_breadcrumbs()
    {
        $routeList = Route::getRoutes()->getRoutesByMethod()['GET'];
        $baseUrl = url('/');
        $segments = Request::segments();
        $routeUries = explode('/', Route::current()->uri());
        $breadcrumbs = [];
        $routeParameters = Request::route()->originalParameters();
        foreach ($segments as $key => $segment) {

            $displayUrl = true;
            $lastBreadcrumb = end($breadcrumbs);
            if (empty($lastBreadcrumb)) {
                $url = $baseUrl . '/' . $segment;
            } else {
                $url = $lastBreadcrumb['url'] . '/' . $segment;

            }

            $uris = array_slice($routeUries, 0, $key + 1);
            $resultUri = '';
            foreach ($uris as $uriKey => $uri) {
                $resultUri .= '/' . $uri;
            }

            if (!array_key_exists(ltrim($resultUri, '/'), $routeList)) {
                $displayUrl = false;
            }
            $breadcrumbs[] = [
                'name' => in_array($segment, $routeParameters) ? $segment : Str::title(preg_replace('/[-_]+/', ' ', $segment)),
                'url' => $url,
                'display_url' => $displayUrl
            ];

        }
        return $breadcrumbs;
    }
}

if (!function_exists('get_notices')) {
    function get_notices()
    {
        $date = Carbon::now();
        $totalMinutes = $date->diffInMinutes($date->copy()->endOfDay());

        $notices = Cache::get('notices', collect([]));

        if ($notices->isEmpty()) {
            $notices = Notice::active()->today()->latest('id')->get();
            if (!$notices->isEmpty()) {
                Cache::put('notices', $notices, $totalMinutes);
            }
        }

        $notices = $notices->filter(function ($notice) use ($date) {
            if ($notice->start_at <= $date && $notice->end_at >= $date) {
                return Auth::check() ? true : ($notice->visible_type === VISIBLE_TYPE_PUBLIC);
            }
            return false;
        });

        $cookeName = 'seenNotices:' . str_replace('.', '-', request()->ip());


        if (Cookie::has($cookeName)) {
            $seenNoticeIds = json_decode(Cookie::get($cookeName), true);
            $notices = $notices->filter(function ($notice) use (&$seenNoticeIds) {
                if (array_key_exists($notice->id, $seenNoticeIds) && $notice->updated_at->equalTo(Carbon::parse($seenNoticeIds[$notice->id]))) {
                    return false;
                }
                $seenNoticeIds[$notice->id] = $notice->updated_at;
                return true;
            });
        } else {
            $seenNoticeIds = $notices->pluck('updated_at', 'id')->toArray();
        }

        if ($notices->isEmpty()) {
            return collect([]);
        }
        Cookie::queue($cookeName, json_encode($seenNoticeIds), $totalMinutes);
        return $notices;
    }
}


if (!function_exists('get_available_timezones')) {
    function get_available_timezones()
    {
        return [
            'UTC' => __('Default'),
            'BST' => __('Bangladesh Standard Time'),
        ];
    }
}

if (!function_exists('form_validation')) {
    function form_validation($errors, $name, $extraClass = null)
    {
        $extraClass = !empty($extraClass) ? ' ' . $extraClass : '';
        return $errors->has($name) ? 'form-control is-invalid' . $extraClass : 'form-control' . $extraClass;
    }
}

if (!function_exists('get_user_roles')) {
    function get_user_roles()
    {
        return Role::where('is_active', ACTIVE)->pluck('name', 'slug')->toArray();
    }
}

if (!function_exists('get_image')) {
    function get_image($image)
    {
        $imagePath = 'public/uploads/' . config('commonconfig.path_image');
        if (valid_image($imagePath, $image)) {
            return asset($imagePath . $image);
        }

        return null;
    }
}

if (!function_exists('get_language_icon')) {
    function get_language_icon($icon)
    {
        $languagePath = 'public/uploads/' . config('commonconfig.language_icon');

        if (valid_image($languagePath, $icon)) {
            return asset($languagePath . $icon);
        }

        return null;
    }
}

if (!function_exists('generate_language_url')) {
    function generate_language_url($language)
    {
        if (is_null(check_language($language))) {
            return 'javascript:;';
        }
        $oldLanguage = request()->segment(1);
        $oldLanguage = check_language($oldLanguage);
        $uri = request()->getRequestUri();

        if ($oldLanguage) {
            $uri = Str::replaceFirst($oldLanguage, $language, $uri);
        } else {
            $uri = $language . $uri;
        }

        return url('/') . '/' . ltrim($uri, '/');
    }
}

if (!function_exists('display_language')) {
    function display_language($lang, $params = null)
    {
        $item = settings('lang_switcher_item');
        $params = is_null($params) ? language($lang) : $params;
        if ($item == 'name') {
            return new HtmlString('<div class="lf-language-text">' . $params['name'] . '</div>');
        } elseif ($item == 'icon') {
            return new HtmlString('<div class="lf-language-image"><img width="30" height="22" src="' . get_language_icon($params['icon']) . '"></div>');
        } else {
            return new HtmlString('<div class="lf-language-text">' . strtoupper($lang) . '</div>');
        }
    }
}

if (!function_exists('display_active_status')) {
    function display_active_status($status)
    {
        if ($status == ACTIVE) {
            return new HtmlString('<i class="fa fa-check text-success"></i>');
        } else {
            return new HtmlString('<i class="fa fa-close text-danger"></i>');
        }
    }
}

if (!function_exists('ticket_comment_attachment_link')) {
    function ticket_comment_attachment_link($route, $file)
    {
        $fileParts = pathinfo($file);
        $path = 'public/uploads/' . config('commonconfig.ticket_attachment') . $file;
        if (in_array($fileParts['extension'], ['jgp', 'jpeg', 'png'])) {
            $htmlString = '<img class="img-fluid" src="' . asset($path) . '" alt="Attachment">';
        } else {
            $htmlString = '<a href="' . $route . '">' . __('Download Attachment') . '</a>';
        }
        return view_html($htmlString);
    }
}

if (!function_exists('active_side_nav')) {
    function active_side_nav()
    {
        return auth()->check() && (auth()->user()->assigned_role === USER_ROLE_ADMIN);
    }
}

if (!function_exists('payment_method_logo')) {
    function payment_method_logo($fileName, $label = 'logo')
    {
        $path = 'public/uploads/' . config('commonconfig.payment_method_logo');

        if (valid_image($path, $fileName)) {
            return asset($path . $fileName);
        }
        return get_image_placeholder(100, 100, 16, $label);
    }
}

if (!function_exists('auction_image')) {
    function auction_image($fileName)
    {

        $path = 'public/uploads/' . config('commonconfig.auction_image');

        if (valid_image($path, $fileName)) {
            return asset($path . $fileName);
        }

        return get_image_placeholder(300, 250, 20, 'Image');
    }
}

if (!function_exists('slider_images')) {
    function slider_images($fileName)
    {
        $path = 'public/uploads/' . config('commonconfig.slider_images');

        $fileName = valid_image($path, $fileName) ? $path . $fileName : $path . 'preview.png';

        return asset($fileName);
    }
}

if (!function_exists('dispute_image')) {
    function dispute_image($fileName)
    {
        $path = 'public/uploads/' . config('commonconfig.dispute_image');

        $fileName = valid_image($path, $fileName) ? $path . $fileName : $path . 'logo.png';

        return asset($fileName);
    }
}

if (!function_exists('currency_logo')) {
    function currency_logo($fileName, $label = 'logo')
    {
        $path = 'public/uploads/' . config('commonconfig.currency_logo');

        if (valid_image($path, $fileName)) {
            return asset($path . $fileName);
        }
        return get_image_placeholder(100, 100, 20, $label);
    }
}

if (!function_exists('know_your_customer_images')) {
    function know_your_customer_images($fileName)
    {
        $path = 'public/uploads/' . config('commonconfig.know_your_customer_images');

        if (valid_image($path, $fileName)) {
            return asset($path . $fileName);
        }
        return get_image_placeholder(600, 800, 60, 'Image');
    }
}

if (!function_exists('get_seller_profile_image')) {
    function get_seller_profile_image($fileName)
    {
        $path = 'public/uploads/' . config('commonconfig.seller_profile_images');

        if (valid_image($path, $fileName)) {
            return asset($path . $fileName);
        }
        return get_image_placeholder(400, 400, 60);
    }
}

if (!function_exists('get_image_placeholder')) {
    function get_image_placeholder($width, $height, $fontSize = 40, $label = null)
    {
        if (is_null($label)) {
            $label = "{$width}×{$height}";
        }

        $svg = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"{$width}\" height=\"{$height}\" viewBox=\"0 0 {$width} {$height}\">
            <rect fill=\"#eee\" width=\"{$width}\" height=\"{$height}\"/>
            <text fill=\"rgba(0,0,0,0.5)\" font-family=\"sans-serif\" font-size=\"{$fontSize}\" dy=\"10.5\" font-weight=\"bold\" x=\"50%\" y=\"50%\" text-anchor=\"middle\">
                {$label}
            </text>
        </svg>";

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}

if (!function_exists('get_color_class')) {
    function get_color_class(string $status, string $type)
    {
        return config("commonconfig.{$type}.{$status}.color_class");
    }
}

if (!function_exists('get_deposit_receipt')) {
    function get_deposit_receipt($image)
    {
        $path = 'public/uploads/' . config('commonconfig.path_deposit_receipt');
        if (valid_image($path, $image)) {
            return asset($path . $image);
        }

        return null;
    }
}
if (!function_exists('get_popular_category')) {
    function get_popular_category($limit)
    {
        return (new Category())->getPopularCategory($limit);
    }
}

if (!function_exists('get_popular_auction')) {
    function get_popular_auction($limit)
    {
        return (new Auction())->getPopularAuction($limit);
    }
}

if (!function_exists('replace_current_route_action')) {
    function replace_current_route_action($action, $fallbackRouteName = "")
    {
        $currentRouteNames = explode(".", Route::getCurrentRoute()->getName());
        $currentRouteNames[count($currentRouteNames) - 1] = $action;
        $modifiedRouteName = implode(".", $currentRouteNames);
        if (Route::has($modifiedRouteName)) {
            return $modifiedRouteName;
        }
        return $fallbackRouteName;
    }
}

if (!function_exists('calculate_deposit_system_fee')) {
    function calculate_deposit_system_fee(float $amount, float $fee, string $type)
    {
        switch ($type) {
            case FEE_TYPE_FIXED:
                return $fee;
            case FEE_TYPE_PERCENT:
                return (($amount * $fee) / 100);
            default:
                return 0;
        }
    }
}
if (!function_exists('calculate_withdrawal_system_fee')) {
    function calculate_withdrawal_system_fee(float $amount, float $fee, string $type)
    {
        switch ($type) {
            case FEE_TYPE_FIXED:
                return $fee;
            case FEE_TYPE_PERCENT:
                return (($amount * $fee) / 100);
            default:
                return 0;
        }
    }
}

if (!function_exists('short_code')) {
    function short_code($string)
    {
        $pattern = '/\<div[^\>](.*?)data-cmb-element-type="dynamic-layout"(.*?)\>(.*?)\<\/div\>/i';
        if (preg_match_all($pattern, $string, $matches)) {

            foreach ($matches[0] as $key => $value) {
                $subPattern = '/data-cmb-dynamic-values="[^"](.*?)"/i';
                preg_match($subPattern, $value, $match);

                if (!$match) {
                    continue;
                }

                $dataString = preg_replace(['/data-cmb-dynamic-values="/', '/"/'], ['', ''], $match[0]);
                if (!$dataString) {
                    continue;
                }
                $dataString = explode('|', $dataString);
                if (!$dataString) {
                    continue;
                }
                $data = [];
                foreach ($dataString as $dataKey => $dataValue) {
                    $dataValue = explode(':', $dataValue);
                    if (!$dataValue) {
                        $data = [];
                        break;
                    }
                    $data[$dataValue[0]] = $dataValue[1];
                }
                if (!$data) {
                    continue;
                }

                $output = '';

                if (function_exists($data['name'])) {
                    $request = new \Illuminate\Http\Request($data);
                    $output = $data['name']($request);
                }

                if (!$output) {
                    continue;
                }
                $output = str_replace('><', '>' . $output . '<', $value);
                $string = str_replace($value, $output, $string);
            }
        }

        return $string;
    }
}

if (!function_exists('get_media_file')) {
    function get_media_file($path,$fileName)
    {

        $mediaPath = 'public/uploads/' . $path.'/';

        if (valid_image($mediaPath, $fileName)){
            $file = $mediaPath . $fileName;
            return asset($file);
        }
        return '';
    }
}

if (!function_exists('generate_media_link')) {
    function generate_media_link($path,$basePath)
    {
        if ($path){
            return $path.'/'.$basePath;
        }
        return $basePath;
    }
}
