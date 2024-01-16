<?php

return [
    'configurable_routes' => [
        'admin_section' => [
            'application-settings' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'application-settings.index',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'application-settings.edit',
                    'application-settings.update',
                ],
            ],
            'role_managements' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'roles.index',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'roles.create',
                    'roles.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'roles.edit',
                    'roles.update',
                    'roles.status',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'roles.destroy',
                ],
            ],
            'user_managements' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'users.index',
                    'users.show',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'users.create',
                    'users.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'users.edit',
                    'users.update',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'users.update.status',
                    'users.edit.status',
                ],
            ],
            'notice_managements' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'notices.index',
                    'notices.show'
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'notices.create',
                    'notices.store'
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'notices.edit',
                    'notices.update',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'notices.destroy',
                ]
            ],
            'store_managements' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.stores.index',
                    'admin.stores.show'
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.stores.edit',
                    'admin.stores.update',
                ],
            ],
            'menu_manager' => [
                ROUTE_GROUP_FULL_ACCESS => [
                    'menu-manager.index',
                    'menu-manager.save',
                ],
            ],
            'log_viewer' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'logs.index'
                ]
            ],
            'language_managements' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'languages.index',
                    'languages.settings',
                    'languages.translations'
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'languages.create',
                    'languages.store'
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'languages.edit',
                    'languages.update',
                    'languages.update.settings',
                    'languages.sync',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'languages.destroy'
                ]
            ],
            'page_managements'=>[
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.pages.index',
                    'admin.dynamic-content',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'admin.pages.create',
                    'admin.pages.store'
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.pages.edit',
                    'admin.pages.update',
                    'admin.pages.visual-edit',
                    'admin.pages.visual-edit',
                    'admin.pages.published',
                    'admin.pages.home-page',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'admin.pages.destroy',
                ]
            ],
            'media_manager'=>[
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.media.index',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'admin.media.store',
                    'admin.directories.store'
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.directories.update'
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'admin.media.destroy',
                    'admin.directories.delete',
                ]
            ],
            'dashboard' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.dashboard.index',
                    'admin.dashboard.earning-source',
                    'admin.dashboard.total-earning',
                ]
            ],
            'tickets' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.tickets.index',
                    'admin.tickets.show',
                    'admin.tickets.attachment.download'
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.tickets.close',
                    'admin.tickets.resolve',
                    'admin.tickets.assign',
                ],
                'commenting_access' => [
                    'admin.tickets.comment.store',
                ]
            ],
            'auction_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.auctions.index',
                    'admin.auctions.show',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin-release-money.update',
                    'admin.auctions.edit',
                    'admin.auctions.update',
                ],
            ],
            'profit_histories' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin-transaction-history.index'
                ],
            ],
            'category_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'category.index',
                    'category.show',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'category.create',
                    'category.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'category.edit',
                    'category.update',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'category.destroy'
                ],
            ],
            'currency_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'currency.index',
                    'currency.show',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'currency.create',
                    'currency.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'currency.edit',
                    'currency.update',
                    'admin.currencies.payment-methods.edit',
                    'admin.currencies.payment-methods.update',
                    'admin.currencies.deposit-options.edit',
                    'admin.currencies.deposit-options.update',
                    'admin.currencies.withdrawal-options.edit',
                    'admin.currencies.withdrawal-options.update',
                ],
            ],
            'bank_deposit_review' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.review.bank-deposits.index',
                    'admin.review.bank-deposits.show',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.adjust.bank-deposits',
                    'admin.review.bank-deposits.update',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'admin.review.bank-deposits.destroy',
                ]
            ],
            'deposit_history' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin.deposit.history.index',
                    'admin.deposit.history.show',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin.deposit.history.update'
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'admin.deposit.history.destroy'
                ]
            ],
            'user_transaction' => [
              ROUTE_GROUP_READER_ACCESS => [
                  'admin.users.wallets',
                  'admin.users.wallets.deposits',
                  'admin.users.wallets.withdrawals',
                  'admin.users.wallet.adjustments'
              ],
              ROUTE_GROUP_CREATION_ACCESS => [
                  'admin.users.wallets.adjust-amount.create',
                  'admin.users.wallets.adjust-amount.store',
              ],
            ],
            'payment_method_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'payment-method.index',
                    'payment-method.show',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'payment-method.create',
                    'payment-method.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'payment-method.edit',
                    'payment-method.update',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'payment-method.destroy'
                ],
            ],
            'address_verification_review' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'kyc.admin.address-review.index',
                    'kyc.admin.address-review.show',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'kyc.admin.address-review.approve',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'kyc.admin.address-review.destroy',
                ],
            ],
            'identity_verification_review' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'kyc.admin.identity-review.index',
                    'kyc.admin.identity-review.show',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'kyc.admin.identity-review.approve',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'kyc.admin.identity-review.destroy',
                ],
            ],
            'system_bank_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'system-banks.index'
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'system-banks.create',
                    'system-banks.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'system-banks.toggle-status',
                ],
            ],
            'reports' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'admin-dispute.index',
                    'admin-dispute.edit',
                    'admin-dispute.mark-as-read',
                    'admin-dispute.mark-as-unread',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'admin-change-dispute-status.update',
                    'admin-dispute-decline-status.update'
                ],
            ],
            'slide_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'slider.index',
                    'slider.show',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'slider.create',
                    'slider.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'slider.edit',
                    'slider.update',
                    'slider-make-default.update',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'slider.destroy'
                ],
            ],
            'home_page_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'layout.index',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'layout.create',
                    'layout.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'layout.edit',
                    'layout.update',
                    'layout-make-active.update',
                ],
            ],
        ],
        'user_section' => [
            'buyer_profile_section' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'buyer-attended-auction.index',
                    'buyer-winning-auction.index',
                ],
            ],
            'address_section' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'user-address.index',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'user-address.create',
                    'user-address.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'user-address.edit',
                    'user-address.update',
                    'user-change-address-status.update',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'user-address.destroy'
                ],
            ],
            'deposit_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'wallets.deposits.index',
                    'wallets.deposits.show',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'wallets.deposits.create',
                    'wallets.deposits.store',
                    'paypal.return-url',
                    'paypal.cancel-url'
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'wallets.deposits.update'
                ],
            ],
            'withdrawal_managements' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'wallets.withdrawals.index',
                    'wallets.withdrawals.show',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'wallets.withdrawals.create',
                    'wallets.withdrawals.store',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'wallets.withdrawals.destroy',
                ],
            ],
            'transaction_histories' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'transaction-history',
                ],
            ],
            'wallets' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'wallets.index',
                ],
            ],
            'back_accounts' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'bank-accounts.index'
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'bank-accounts.create',
                    'bank-accounts.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'bank-accounts.edit',
                    'bank-accounts.update',
                    'bank-accounts.toggle-status',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'bank-accounts.destroy',
                ],
            ],
            'biding_access' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'bid.index',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'bid.store',
                ],
            ],
            'comment_access' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'comment.index',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'comment.create',
                    'comment.store',
                    'comment.reply'
                ],
            ],
            'shipping_management' => [
                ROUTE_GROUP_CREATION_ACCESS => [
                    'shipping-description.create',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'shipping-description.update',
                    'buyer.confirm-delivery'
                ],
            ],
            'dispute_access' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'dispute.index',
                    'dispute.edit',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'dispute.create',
                    'dispute.store',
                    'disputes.specific',
                ],
            ],
            'notifications_access' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'notification.index',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'notification.mark-as-read',
                    'notification.mark-as-unread',
                ],
            ],
            'become_a_seller' => [
                ROUTE_GROUP_CREATION_ACCESS => [
                    'become-a-seller.create',
                    'become-a-seller.store'
                ],
            ],
            'seller_profile' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'seller.store.show',
                ],
            ],
        ],
        'seller_section' => [
            'address_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'kyc.seller.addresses.index',
                    'kyc.seller.addresses.verification.show',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'kyc.seller.addresses.create',
                    'kyc.seller.addresses.store',
                    'kyc.seller.addresses.verification.create',
                    'kyc.seller.addresses.verification.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'kyc.seller.addresses.edit',
                    'kyc.seller.addresses.update',
                    'kyc.seller.addresses.toggle-default-status',
                ],
                ROUTE_GROUP_DELETION_ACCESS => [
                    'kyc.seller.addresses.destroy',
                ],
            ],
            'profile_management' => [
                ROUTE_GROUP_READER_ACCESS => [
                    'seller.store.index',
                    'store-management.index',
                ],
                ROUTE_GROUP_CREATION_ACCESS => [
                    'seller.store.create',
                    'seller.store.store',
                ],
                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'seller.store.edit',
                    'seller.store.update',
                ],
            ],
            'manage_auction' => [
                ROUTE_GROUP_CREATION_ACCESS => [
                    'auction.create',
                    'auction.store',
                    'seller.shipping-description.create',
                    'seller.shipping-description.store',
                ],

                ROUTE_GROUP_MODIFIER_ACCESS => [
                    'auction.start',
                    'auction.edit',
                    'auction.update',
                    'update-shipping-status.update',
                    'release.seller.money'
                ]
            ],
        ]
    ],
    ROUTE_TYPE_ROLE_BASED => [
        USER_ROLE_ADMIN => [

        ],
        USER_ROLE_USER => [

        ]
    ],

    ROUTE_TYPE_AVOIDABLE_MAINTENANCE => [
        'login',
        'tickets.index',
    ],

    ROUTE_TYPE_AVOIDABLE_UNVERIFIED => [
        'logout',
        'profile.index',
        'notifications.index',
        'notifications.mark-as-read'
    ],
    ROUTE_TYPE_AVOIDABLE_INACTIVE => [
        'logout',
        'profile.index',
        'notifications.index',
        'notifications.mark-as-read',
        'notifications.mark-as-unread',
    ],
    ROUTE_TYPE_FINANCIAL => [

    ],

    ROUTE_TYPE_GLOBAL => [
        'logout',
        'profile.index',
        'profile.edit',
        'profile.update',
        'profile.change-password',
        'kyc.addresses.index',
        'kyc.addresses.create',
        'kyc.addresses.store',
        'kyc.addresses.edit',
        'kyc.addresses.update',
        'kyc.addresses.toggle-default-status',
        'kyc.addresses.destroy',
        'kyc.addresses.toggle-default-status',
        'kyc.addresses.verification.create',
        'kyc.addresses.verification.store',
        'kyc.addresses.verification.show',
        'kyc.identity.index',
        'kyc.identity.store',

        'profile.update-password',
        'profile.avatar.edit',
        'profile.avatar.update',
        'notifications.index',
        'notifications.mark-as-read',
        'notifications.mark-as-unread',
    ],

];
