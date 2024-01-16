<?php

use App\Models\Core\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $adminSection = [
            "application-settings" => [
                "reader_access",
                "modifier_access"
            ],
            "user_managements" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "notice_managements" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "store_managements" => [
                "reader_access",
                "modifier_access"
            ],
            "menu_manager" => [
                "full_access"
            ],
            "log_viewer" => [
                "reader_access"
            ],
            "language_managements" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "page_managements" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "media_manager" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "dashboard" => [
                "reader_access"
            ],
            "tickets" => [
                "reader_access",
                "modifier_access",
                "commenting_access"
            ],
            "auction_management" => [
                "reader_access",
                "modifier_access"
            ],
            "profit_histories" => [
                "reader_access"
            ],
            "category_management" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "currency_management" => [
                "reader_access",
                "creation_access",
                "modifier_access"
            ],
            "bank_deposit_review" => [
                "reader_access",
                "modifier_access",
                "deletion_access"
            ],
            "deposit_history" => [
                "reader_access",
                "modifier_access",
                "deletion_access"
            ],
            "user_transaction" => [
                "reader_access"
            ],
            "payment_method_management" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "address_verification_review" => [
                "reader_access",
                "modifier_access",
                "deletion_access"
            ],
            "identity_verification_review" => [
                "reader_access",
                "modifier_access",
                "deletion_access"
            ],
            "system_bank_management" => [
                "reader_access",
                "creation_access",
                "modifier_access"
            ],
            "reports" => [
                "reader_access",
                "modifier_access"
            ],
            "slide_management" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "home_page_management" => [
                "reader_access",
                "creation_access",
                "modifier_access"
            ]
        ];
        $userSection = [
            "buyer_profile_section" => [
                "reader_access"
            ],
            "address_section" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "deposit_management" => [
                "reader_access",
                "creation_access",
                "modifier_access"
            ],
            "withdrawal_managements" => [
                "reader_access",
                "creation_access",
                "deletion_access"
            ],
            "transaction_histories" => [
                "reader_access"
            ],
            "wallets" => [
                "reader_access"
            ],
            "back_accounts" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "biding_access" => [
                "reader_access",
                "creation_access"
            ],
            "comment_access" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "shipping_management" => [
                "creation_access",
                "modifier_access"
            ],
            "dispute_access" => [
                "reader_access",
                "creation_access"
            ],
            "notifications_access" => [
                "reader_access",
                "modifier_access"
            ],
            "seller_profile" => [
                "reader_access"
            ]
        ];
        $sellerSection = [
            "address_management" => [
                "reader_access",
                "creation_access",
                "modifier_access",
                "deletion_access"
            ],
            "profile_management" => [
                "reader_access",
                "creation_access",
                "modifier_access"
            ],
            "manage_auction" => [
                "creation_access",
                "modifier_access"
            ]
        ];

        $adminWebPermissions = [
            "admin_section" => $adminSection,
            "user_section" => $userSection,
        ];

        $userWebPermissions = [
            "user_section" => [
                "buyer_profile_section" => [
                    "reader_access"
                ],
                "address_section" => [
                    "reader_access",
                    "creation_access",
                    "modifier_access",
                    "deletion_access"
                ],
                "deposit_management" => [
                    "reader_access",
                    "creation_access",
                    "modifier_access"
                ],
                "withdrawal_managements" => [
                    "reader_access",
                    "creation_access",
                    "deletion_access"
                ],
                "transaction_histories" => [
                    "reader_access"
                ],
                "wallets" => [
                    "reader_access"
                ],
                "back_accounts" => [
                    "reader_access",
                    "creation_access",
                    "modifier_access",
                    "deletion_access"
                ],
                "biding_access" => [
                    "reader_access",
                    "creation_access"
                ],
                "comment_access" => [
                    "reader_access",
                    "creation_access",
                    "modifier_access",
                    "deletion_access"
                ],
                "shipping_management" => [
                    "creation_access",
                    "modifier_access"
                ],
                "dispute_access" => [
                    "reader_access",
                    "creation_access"
                ],
                "notifications_access" => [
                    "reader_access",
                    "modifier_access"
                ],
                "become_a_seller" => [
                    "creation_access"
                ],
                "seller_profile" => [
                    "reader_access"
                ]
            ],
        ];

        $sellerPermissions = [
            "user_section" => $userSection,
            "seller_section" => $sellerSection,
        ];

        $adminApiPermissions = [
            'admin_section' => [
                'user' => [
                    'reader_access',
                ],
            ],
        ];

        $sellerApiPermissions = [];

        $userApiPermissions = [];

        factory(Role::class)->create([
            'name' => 'Admin',
            'permissions' => [
                'web' => $adminWebPermissions,
                'api' => $adminApiPermissions,
            ],
            'accessible_routes' => [
                'web' => build_permission('web', $adminWebPermissions, 'admin'),
                'api' => build_permission('api', $adminApiPermissions, 'admin'),
            ],
            'is_active' => ACTIVE
        ]);

        factory(Role::class)->create([
            'name' => 'User',
            'permissions' => [
                'web' => $userWebPermissions,
                'api' => $userApiPermissions,
            ],
            'accessible_routes' => [
                'web' => build_permission('web', $userWebPermissions, 'user'),
                'api' => build_permission('api', $userApiPermissions, 'user'),
            ],
            'is_active' => ACTIVE
        ]);

        factory(Role::class)->create([
            'name' => 'Seller',
            'permissions' => [
                'web' => $sellerPermissions,
                'api' => $sellerApiPermissions,
            ],
            'accessible_routes' => [
                'web' => build_permission('web', $sellerPermissions, 'seller'),
                'api' => build_permission('api', $sellerApiPermissions, 'seller'),
            ],
            'is_active' => ACTIVE
        ]);
    }
}
