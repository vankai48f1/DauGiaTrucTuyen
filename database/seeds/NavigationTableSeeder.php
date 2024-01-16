<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class NavigationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            [
                'slug' => 'top-nav',
                'items' => '[{"name":"Home","value":{"name":"home"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"1"},{"name":"My Store","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"2"},{"name":"Store","value":{"name":"seller.store.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"2","new_tab":"0","mega_menu":"0","order":"3"},{"name":"Create Auction","value":{"name":"auction.create"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"2","new_tab":"0","mega_menu":"0","order":"4"},{"name":"My Wallets","value":{"name":"wallets.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"5"},{"name":"Auction","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"6"},{"name":"All Auctions","value":{"name":"auction.home"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"6","new_tab":"0","mega_menu":"0","order":"7"},{"name":"My Attended Auctions","value":{"name":"buyer-attended-auction.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"6","new_tab":"0","mega_menu":"0","order":"8"},{"name":"Dispute","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"9"},{"name":"My Dispute List","value":{"name":"dispute.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"9","new_tab":"0","mega_menu":"0","order":"10"},{"name":"Create New Dispute","value":{"name":"dispute.create"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"9","new_tab":"0","mega_menu":"0","order":"11"}]',
                'created_at' => Date::now(),
                'updated_at' => Date::now()
            ],
            [
                'slug' => 'side-nav',
                'items' => '[{"name":"Home","value":{"name":"home"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"1"},{"name":"Dashboard","value":{"name":"admin.dashboard.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"2"},{"name":"Application Control","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"3"},{"name":"Application Settings","value":{"name":"application-settings.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"3","new_tab":"0","mega_menu":"0","order":"4"},{"name":"Role Management","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"3","new_tab":"0","mega_menu":"0","order":"5"},{"name":"List","value":{"name":"roles.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"5","new_tab":"0","mega_menu":"0","order":"6"},{"name":"Create","value":{"name":"roles.create"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"5","new_tab":"0","mega_menu":"0","order":"7"},{"name":"Language management","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"3","new_tab":"0","mega_menu":"0","order":"8"},{"name":"Settings","value":{"name":"languages.settings"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"8","new_tab":"0","mega_menu":"0","order":"9"},{"name":"List","value":{"name":"languages.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"8","new_tab":"0","mega_menu":"0","order":"10"},{"name":"Create","value":{"name":"languages.create"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"8","new_tab":"0","mega_menu":"0","order":"11"},{"name":"Menu Manager","value":{"name":"menu-manager.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"3","new_tab":"0","mega_menu":"0","order":"12"},{"name":"Logs","value":{"name":"logs.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"3","new_tab":"0","mega_menu":"0","order":"13"},{"name":"Notice Management","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"3","new_tab":"0","mega_menu":"0","order":"14"},{"name":"List","value":{"name":"notices.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"14","new_tab":"0","mega_menu":"0","order":"15"},{"name":"Create","value":{"name":"notices.create"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"14","new_tab":"0","mega_menu":"0","order":"16"},{"name":"User Management","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"17"},{"name":"List","value":{"name":"admin.users.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"17","new_tab":"0","mega_menu":"0","order":"18"},{"name":"Create","value":{"name":"admin.users.create"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"17","new_tab":"0","mega_menu":"0","order":"19"},{"name":"Media Manager","value":{"name":"admin.media.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"20"},{"name":"Page Management","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"21"},{"name":"List","value":{"name":"admin.pages.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"21","new_tab":"0","mega_menu":"0","order":"22"},{"name":"Create","value":{"name":"admin.pages.create"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"21","new_tab":"0","mega_menu":"0","order":"23"},{"name":"Ticket Management","value":{"name":"admin.tickets.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"24"},{"name":"User Section","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"25"},{"name":"Supports","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"25","new_tab":"0","mega_menu":"0","order":"26"},{"name":"My Ticket","value":{"name":"tickets.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"26","new_tab":"0","mega_menu":"0","order":"27"},{"name":"Create Ticket","value":{"name":"tickets.create"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"26","new_tab":"0","mega_menu":"0","order":"28"},{"name":"Auctions","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"29"},{"name":"Auction List","value":{"name":"admin.auctions.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"29","new_tab":"0","mega_menu":"0","order":"30"},{"name":"Completed Auction List","value":{"name":"admin.completed-auctions.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"29","new_tab":"0","mega_menu":"0","order":"31"},{"name":"Category","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"32"},{"name":"Category List","value":{"name":"admin.categories.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"32","new_tab":"0","mega_menu":"0","order":"33"},{"name":"Add New Category","value":{"name":"admin.categories.create"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"32","new_tab":"0","mega_menu":"0","order":"34"},{"name":"Currency ","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"35"},{"name":"Currency List","value":{"name":"admin.currencies.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"35","new_tab":"0","mega_menu":"0","order":"36"},{"name":"Add New Currency","value":{"name":"admin.currencies.create"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"35","new_tab":"0","mega_menu":"0","order":"37"},{"name":"Store Management","value":{"name":"admin.stores.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"38"},{"name":"KYC Verification","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"39"},{"name":"Address Review","value":{"name":"kyc.admin.address-review.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"39","new_tab":"0","mega_menu":"0","order":"40"},{"name":"Identity Review","value":{"name":"kyc.admin.identity-review.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"39","new_tab":"0","mega_menu":"0","order":"41"},{"name":"Dispute","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"42"},{"name":"Dispute List","value":{"name":"admin-dispute.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"42","new_tab":"0","mega_menu":"0","order":"43"},{"name":"Manage Withdrawal","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"44"},{"name":"Withdrawal Review List","value":{"name":"admin.review.withdrawals.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"44","new_tab":"0","mega_menu":"0","order":"45"},{"name":"Withdrawal History","value":{"name":"admin.history.withdrawals.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"44","new_tab":"0","mega_menu":"0","order":"46"},{"name":"Manage Deposit","value":{"name":"javascript:;"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"link","parent_id":"0","new_tab":"0","mega_menu":"0","order":"47"},{"name":"Bank Deposit Review List","value":{"name":"admin.review.bank-deposits.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"47","new_tab":"0","mega_menu":"0","order":"48"},{"name":"Deposit History","value":{"name":"admin.deposit.history.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"47","new_tab":"0","mega_menu":"0","order":"49"}]',
                'created_at' => Date::now(),
                'updated_at' => Date::now()
            ],
            [
                'slug' => 'profile-nav',
                'items' => '[{"name":"My Profile","value":{"name":"profile.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"1"},{"name":"Become A Seller","value":{"name":"become-a-seller.create"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"2"},{"name":"Edit Profile","value":{"name":"profile.edit"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"3"},{"name":"Change Password","value":{"name":"profile.change-password"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"4"},{"name":"Change Avatar","value":{"name":"profile.avatar.edit"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"5"},{"name":"My Notifications","value":{"name":"notifications.index"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"6"},{"name":"Verify Account","value":{"name":"verification.form"},"class":"","icon":"","beginning_text":"","ending_text":"","type":"route","parent_id":"0","new_tab":"0","mega_menu":"0","order":"7"}]',
                'created_at' => Date::now(),
                'updated_at' => Date::now()
            ],

        ];

        foreach ($input as $value) {
            Cache::forever("navigation:" . $value['slug'], json_decode($value['items'], true));
        }
        DB::table('navigations')->insert($input);
    }
}