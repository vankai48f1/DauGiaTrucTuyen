<?php
return [
    'settings' => [
        'preference' => [
            'icon' => 'fa-home',
            'sub-settings' => [
                'general' => [
                    'company_name' => [
                        'field_type' => 'text',
                        'validation' => 'required',
                        'field_label' => 'Company Name',
                    ],
                    'lang' => [
                        'field_type' => 'select',
                        'field_value' => 'language_short_code_list',
                        'default' => config('app.locale'),
                        'field_label' => 'Default Site Language',
                    ],
                    'lang_switcher' => [
                        'field_type' => 'switch',
                        'field_label' => 'Language Switcher',
                    ],
                    'lang_switcher_item' => [
                        'field_type' => 'radio',
                        'field_value' => 'language_switcher_items',
                        'default' => 'icon',
                        'field_label' => 'Display Language Switch Item',
                    ],
                    'maintenance_mode' => [
                        'field_type' => 'switch',
                        'field_label' => 'Maintenance mode',
                    ],
                ],
                'accounts' => [
                    'registration_active_status' => [
                        'field_type' => 'switch',
                        'field_label' => 'Allow Registration',
                    ],
                    'default_role_to_register' => [
                        'field_type' => 'select',
                        'field_value' => 'get_user_roles',
                        'field_label' => 'Default registration role',
                    ],
                    'require_email_verification' => [
                        'field_type' => 'switch',
                        'field_label' => 'Require Email Verification',
                    ],
                    'admin_receive_email' => [
                        'field_type' => 'text',
                        'validation' => 'required|email',
                        'field_label' => 'Email to receive customer feedback',
                    ],
                ],
                'mail' => [
                    'mail_driver' => [
                        'field_type' => 'select',
                        'validation' => 'required',
                        'field_label' => 'Driver',
                        'field_value' => ["smtp" => "SMTP", "sendmail" => "SendMail", "mailgun" => "Mailgun", "ses" => "SES", "postmark" => "Postmark", "log" => "Log", "array" => "Array"],
                        'default' => env('MAIL_MAILER'),
                    ],
                    'mail_host' => [
                        'field_type' => 'text',
                        'validation' => 'required',
                        'field_label' => 'Host',
                        'default' => env('MAIL_HOST'),
                        'display_when' => ['mail_driver' => ['smtp']],
                    ],
                    'mail_port' => [
                        'field_type' => 'text',
                        'validation' => 'required',
                        'field_label' => 'Port',
                        'default' => env('MAIL_PORT'),
                        'display_when' => ['mail_driver' => ['smtp']],
                    ],
                    'mail_username' => [
                        'field_type' => 'text',
                        'validation' => 'required',
                        'field_label' => 'Username',
                        'encryption' => true,
                        'default' => env('MAIL_USERNAME'),
                        'display_when' => ['mail_driver' => ['smtp']],
                    ],
                    'mail_password' => [
                        'field_type' => 'text',
                        'validation' => 'required',
                        'field_label' => 'Password',
                        'encryption' => true,
                        'default' => env('MAIL_PASSWORD'),
                        'display_when' => ['mail_driver' => ['smtp']],
                    ],
                    'mail_from_address' => [
                        'field_type' => 'text',
                        'field_label' => 'From Address',
                        'default' => env('MAIL_FROM_ADDRESS'),
                        'display_when' => ['mail_driver' => ['smtp']],
                    ],

                    'mail_from_name' => [
                        'field_type' => 'text',
                        'field_label' => 'From Name',
                        'default' => env('MAIL_FROM_NAME'),
                        'display_when' => ['mail_driver' => ['smtp']],
                    ],

                    'mail_encryption' => [
                        'field_type' => 'text',
                        'field_label' => 'Encryption',
                        'default' => env('MAIL_ENCRYPTION'),
                        'display_when' => ['mail_driver' => ['smtp']],
                    ],
                ],
                'google-recaptcha' => [
                    'display_google_captcha' => [
                        'field_type' => 'switch',
                        'field_label' => 'Google Captcha Protection',
                    ],
                    'google_captcha_secret' => [
                        'field_type' => 'text',
                        'field_label' => 'Secret',
                        'encryption' => true,
                        'default' => env('NOCAPTCHA_SECRET'),
                    ],
                    'google_captcha_sitekey' => [
                        'field_type' => 'text',
                        'field_label' => 'Sitekey',
                        'encryption' => true,
                        'default' => env('NOCAPTCHA_SITEKEY'),
                    ],
                ]
            ],
        ],
        'layout' => [
            'icon' => 'fa-align-center',
            'sub-settings' => [
                'logo-and-icon' => [
                    'company_logo' => [
                        'field_type' => 'image',
                        'height' => 120,
                        'width' => 120,
                        'validation' => 'image|size:512',
                        'field_label' => 'Company Logo',
                    ],
                    'logo_inversed_sidenav' => [
                        'field_type' => 'switch',
                        'field_value' => 'inversed_logo',
                        'default' => '1',
                        'field_label' => 'Active inversed Logo Color in side nav',
                    ],
                    'logo_inversed_secondary' => [
                        'field_type' => 'switch',
                        'field_value' => 'inversed_logo',
                        'default' => '1',
                        'field_label' => 'Active inversed Logo Color in no header layout',
                    ],
                    'favicon' => [
                        'field_type' => 'image',
                        'height' => 64,
                        'width' => 64,
                        'validation' => 'image|size:100',
                        'field_label' => 'Favicon',
                    ],
                ],
                'navigation' => [
                    'navigation_type' => [
                        'field_type' => 'radio',
                        'field_value' => 'navigation_type',
                        'default' => 0,
                        'field_label' => 'Visible Navigation type',
                    ],
                    'top_nav' => [
                        'field_type' => 'select',
                        'field_value' => 'top_nav_type',
                        'default' => '0',
                        'field_label' => 'Top nav Layout',
                    ],
                    'logo_inversed_primary' => [
                        'field_type' => 'switch',
                        'field_value' => 'inversed_logo',
                        'default' => '0',
                        'field_label' => 'Active inversed Logo Color in top nav',
                    ],
                    'side_nav' => [
                        'field_type' => 'select',
                        'field_value' => 'side_nav_type',
                        'default' => '0',
                        'field_label' => 'Side nav Layout',
                    ],
                    'side_nav_fixed' => [
                        'field_type' => 'switch',
                        'field_value' => 'inversed_logo',
                        'default' => '0',
                        'field_label' => 'Active fixed side nav',
                    ],
                    'no_header_layout' => [
                        'field_type' => 'select',
                        'field_value' => 'no_header_layout',
                        'default' => '1',
                        'field_label' => 'No header layout type',
                    ],
                ],
            ],
        ],
        'auction_settings' => [
            'icon' => 'fa-gear',
            'sub-settings' => [
                'auctions' => [
                    'auction_fee_type' => [
                        'field_type' => 'select',
                        'field_value' => 'auction_fee_type',
                        'field_label' => 'Auction Fee Type',
                    ],
                    'auction_fee_in_percent' =>[
                        'field_type'=>'text',
                        'validation' => 'numeric|between:0,100',
                        'field_label' => 'Auction Fee in Percent',
                    ],
                    'auction_fee_in_fixed_amount' =>[
                        'field_type'=>'text',
                        'validation' => 'numeric|between:0,100',
                        'field_label' => 'Auction Fee in Fixed Amount',
                    ],
                    'bidding_fee_on_highest_bidder_auction' =>[
                        'field_type'=>'text',
                        'validation' => 'required|numeric|between:0,100',
                        'field_label' => 'Bidding Fee On ' .'<strong>'. 'Highest Bidder Auction' . '</strong>',
                    ],
                    'bidding_fee_on_blind_bidder_auction' =>[
                        'field_type'=>'text',
                        'validation' => 'required|numeric|between:0,100',
                        'field_label' => 'Bidding Fee On ' .'<strong>'. 'Blind Bidder Auction' . '</strong>',
                    ],
                    'bidding_fee_on_unique_bidder_auction' =>[
                        'field_type'=>'text',
                        'validation' => 'required|numeric|between:0,100',
                        'field_label' => 'Bidding Fee On ' .'<strong>'. 'Unique Bidder Auction' . '</strong>',
                    ],
                    'bidding_fee_on_vickrey_bidder_auction' =>[
                        'field_type'=>'text',
                        'validation' => 'required|numeric|between:0,100',
                        'field_label' => 'Bidding Fee On ' .'<strong>'. 'Vickrey Bidder Auction' . '</strong>',
                    ],
                    'seller_money_release_request' => [
                        'field_type' => 'switch',
                        'field_label' => 'Seller Money Release Request',
                    ],
                    'is_id_verified' => [
                        'field_type' => 'switch',
                        'field_label' => 'Required Id Verification On Bid',
                    ],
                    'is_address_verified' => [
                        'field_type' => 'switch',
                        'field_label' => 'Required Address Verification On Bid',
                    ],
                    'dispute_time' => [
                        'field_type' => 'text',
                        'field_label' => 'Buyer Report Time (In Days)',
                    ],
                ],

            ],
        ],
        'payment_settings' => [
            'icon' => 'fa-money',
            'sub-settings' => [
                'paypal' => [
                    'paypal_client_id' => [
                        'field_type' => 'text',
                        'field_label' => 'Client ID',
                        'encryption' => true
                    ],
                    'paypal_secret' => [
                        'field_type' => 'text',
                        'field_label' => 'Secret',
                        'encryption' => true
                    ],
                    'paypal_webhook_id' => [
                        'field_type' => 'text',
                        'field_label' => 'Paypal Webhook ID',
                        'encryption' => true
                    ],
                    'paypal_mode' => [
                        'field_type' => 'select',
                        'field_label' => 'Mode',
                        'field_value' => 'get_paypal_mode',
                    ],
                ],

            ],
        ],
        'page_information' => [
            'icon' => 'fa-info',
            'sub-settings' => [
                'address' => [
                    'business_address' => [
                        'field_type' => 'text',
                        'validation' => 'string',
                        'field_label' => 'Business Address',
                    ],
                    'business_contact_number' => [
                        'field_type' => 'text',
                        'validation' => 'string',
                        'field_label' => 'Business Contact Number',
                    ],
                    'copy_rights_year' => [
                        'field_type' => 'text',
                        'validation' => 'string',
                        'field_label' => 'Copy Rights Year',
                    ],
                    'rights_reserved' => [
                        'field_type' => 'text',
                        'validation' => 'string',
                        'field_label' => 'Footer All Rights Reserved By',

                    ],
                ],
            ],
        ],
        'media' => [
            'icon' => 'fa-image',
            'sub-settings' => [
                'image' => [
                    'max_media_image_upload_size' => [
                        'field_type' => 'text',
                        'validation' => 'numeric',
                        'field_label' => 'Maximum Upload Size'
                    ],
                ],
            ],
        ],
    ],


    /*
     * ----------------------------------------
     * ----------------------------------------
     * ALL WRAPPER HERE
     * ----------------------------------------
     * ----------------------------------------
    */
    'common_wrapper' => [
        'section_start_tag' => '<div class="form-group row">',
        'section_end_tag' => '</div>',
        'slug_start_tag' => '<label for="" class="col-md-4 control-label">',
        'slug_end_tag' => '</label>',
        'value_start_tag' => '<div class="col-md-8">',
        'value_end_tag' => '</div>',
    ],
    'common_text_input_wrapper' => [
        'input_start_tag' => '',
        'input_end_tag' => '',
        'input_class' => 'form-control lf-toggle-bg-input lf-toggle-border-color',
    ],
    'common_textarea_input_wrapper' => [
        'input_start_tag' => '',
        'input_end_tag' => '',
        'input_class' => 'form-control lf-toggle-bg-input lf-toggle-border-color',
    ],
    'common_select_input_wrapper' => [
        'input_start_tag' => '',
        'input_end_tag' => '',
        'input_class' => 'form-control lf-toggle-bg-input lf-toggle-border-color',
    ],
    'common_checkbox_input_wrapper' => [
        'input_start_tag' => '<div class="setting-checkbox">',
        'input_end_tag' => '</div>',
//        'input_class'=>'setting-checkbox',
    ],
    'common_radio_input_wrapper' => [
        'input_start_tag' => '<div class="setting-checkbox">',
        'input_end_tag' => '</div>',
        'input_class' => 'setting-radio',
    ],
    'common_toggle_input_wrapper' => [
        'input_start_tag' => '<div class="text-right">',
        'input_end_tag' => '</div>',
//        'input_class'=>'setting-checkbox',
    ],
];
