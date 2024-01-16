<?php

namespace App\Providers;

use App\Models\Core\ApplicationSetting;
use App\Services\Logger\Logger;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {

            $applicationSettings = settings();
            if (empty($applicationSettings)) {
                $applicationSettings = ApplicationSetting::pluck('value', 'slug')->toArray();
                foreach ($applicationSettings as $key => $val) {
                    if (is_json($val)) {
                        $applicationSettings[$key] = json_decode($val, true);
                    }
                }
                Cache::forever('appSettings', $applicationSettings);
            }

            $mailConfig = [
                'driver' => settings('mail_driver', env('MAIL_MAILER')),
                'host' => settings('mail_host', env('MAIL_HOST')),
                'port' => settings('mail_port', env('MAIL_PORT')),
                'from' => [
                    'address' => settings('mail_from_address', env('MAIL_FROM_ADDRESS')),
                    'name' => settings('mail_from_name', env('MAIL_FROM_NAME'))
                ],
                'encryption' => settings('mail_encryption', env('MAIL_ENCRYPTION')),
                'username' => settings('mail_username', env('MAIL_USERNAME')),
                'password' => settings('mail_password', env('MAIL_PASSWORD')),
            ];

            Config::set('mail', $mailConfig);

            $captchaConfig = [
                "secret" => settings('google_captcha_secret', env('NOCAPTCHA_SECRET')),
                "sitekey" => settings('google_captcha_sitekey', env('NOCAPTCHA_SITEKEY')),
                "options" => [
                    "timeout" => 30
                ],
            ];

            Config::set('captcha', $captchaConfig);
        } catch (Exception $exception) {
            Logger::error($exception);
        }
    }
}
