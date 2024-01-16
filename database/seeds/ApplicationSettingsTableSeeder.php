<?php

use App\Models\Core\ApplicationSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class ApplicationSettingsTableSeeder extends Seeder
{
    public function run()
    {
        $date_time = date('Y-m-d H:i:s');
        $adminSettingArray = [
            'lang' => 'en',
            'lang_switcher' => ACTIVE,
            'lang_switcher_item' => 'short_code',
            'registration_active_status' => ACTIVE,
            'default_role_to_register' => USER_ROLE_USER,
            'require_email_verification' => ACTIVE,
            'company_name' => 'Auctioneer',
            'company_logo' => 'logo.png',
            'navigation_type' => 2,
            'top_nav' => 1,
            'side_nav' => 1,
            'side_nav_fixed' => 1,
            'logo_inversed_primary' => 0,
            'no_header_layout' => 0,
            'logo_inversed_secondary' => 0,
            'logo_inversed_sidenav' => 0,
            'favicon' => 'favicon.png',
            'maintenance_mode' => 0,
            'admin_receive_email' => 'youremail@gmail.com',
            'display_google_captcha' => INACTIVE,
            'bidding_fee_on_highest_bidder_auction' => 5,
            'bidding_fee_on_blind_bidder_auction' => 5,
            'bidding_fee_on_unique_bidder_auction' => 5,
            'bidding_fee_on_vickrey_bidder_auction' => 5,
            'dispute_time' => 7,
            'is_id_verified' => INACTIVE,
            'is_address_verified' => INACTIVE,
            'business_address' => '4857  Diamond Street',
            'business_contact_number' => '828-504-6577',
            'copy_rights_year' => '2020',
            'rights_reserved' => 'Auctioneer',
        ];

        $adminSetting = [];
        foreach ($adminSettingArray as $key => $value) {
            $adminSetting[] = [
                'slug' => $key,
                'value' => is_array($value) ? json_encode($value) : $value,
                'created_at' => $date_time,
                'updated_at' => $date_time
            ];
        }
        ApplicationSetting::insert($adminSetting);

        Cache::forever("appSettings", $adminSettingArray);
    }
}
