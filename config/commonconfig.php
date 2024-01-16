<?php
return [

    'fixed_roles' => [USER_ROLE_ADMIN, USER_ROLE_USER],

    'path_profile_image' => 'images/users/',
    'path_image' => 'images/',
    'language_icon' => 'images/languages/',
    'ticket_attachment' => 'images/tickets/',
    'payment_method_logo' => 'images/payment_method_logo/',
    'currency_logo' => 'images/currency_logo/',
    'path_deposit_receipt' => 'images/deposit/',
    'know_your_customer_images' => 'images/know_your_customer_images/',
    'seller_profile_images' => 'images/seller_profile_images/',
    'auction_image' => 'images/auction_image/',
    'dispute_image' => 'images/dispute_image/',
    'slider_images' => 'images/slider_images/',
    'email_status' => [
        ACTIVE => ['color_class' => 'success'],
        INACTIVE => ['color_class' => 'danger'],
    ],
    'account_status' => [
        STATUS_ACTIVE => ['color_class' => 'success'],
        STATUS_INACTIVE => ['color_class' => 'warning'],
        STATUS_DELETED => ['color_class' => 'danger'],
    ],
    'seller_account_status' => [
        ACTIVE => ['color_class' => 'success'],
        INACTIVE => ['color_class' => 'warning'],
        DELETED => ['color_class' => 'danger'],
    ],
    'maintenance_accessible_status' => [
        ACTIVE => ['color_class' => 'success'],
        INACTIVE => ['color_class' => 'danger'],
    ],

    'ticket_status' => [
        STATUS_OPEN => ['color_class' => 'info'],
        STATUS_IN_PROGRESS => ['color_class' => 'warning'],
        STATUS_RESOLVED => ['color_class' => 'success'],
        STATUS_CLOSED => ['color_class' => 'danger'],
    ],

    'image_extensions' => ['png', 'jpg', 'jpeg', 'gif'],

    'strip_tags' => [
        'escape_text' => ['beginning_text', 'ending_text', 'body'],
    ],

    'available_commands' => [
        'cache' => 'cache:clear',
        'config' => 'config:clear',
        'route' => 'route:clear',
        'view' => 'view:clear',
    ],

    'financial_status' => [
        FINANCIAL_STATUS_ACTIVE => ['color_class' => 'success'],
        FINANCIAL_STATUS_INACTIVE => ['color_class' => 'danger'],
    ],
    'active_status' => [
        ACTIVE => ['color_class' => 'success'],
        INACTIVE => ['color_class' => 'danger'],
    ],
    'is_multi_bid_allowed' => [
        ACTIVE_STATUS_ACTIVE => ['color_class' => 'bg-success text-white', 'text' => 'Yes'],
        ACTIVE_STATUS_INACTIVE => ['color_class' => 'bg-danger text-white', 'text' => 'No'],
    ],
    'verification_status' => [
        VERIFICATION_STATUS_UNVERIFIED => ['color_class' => 'danger', 'text' => 'UNVERIFIED'],
        VERIFICATION_STATUS_APPROVED => ['color_class' => 'success', 'text' => 'APPROVED'],
        VERIFICATION_STATUS_PENDING => ['color_class' => 'warning', 'text' => 'PENDING'],
    ],
    'identification_type' => [
        IDENTIFICATION_TYPE_WITH_ID_NID => ['color_class' => 'info', 'text' => 'NID'],
        IDENTIFICATION_TYPE_WITH_ID_DRIVING_LICENSE => ['color_class' => 'success', 'text' => 'Driving License'],
        IDENTIFICATION_TYPE_WITH_ID_PASSPORT => ['color_class' => 'primary', 'text' => 'Passport'],
    ],
    'auction_type' => [
        AUCTION_TYPE_HIGHEST_BIDDER => ['color_class' => 'warning'],
        AUCTION_TYPE_BLIND_BIDDER => ['color_class' => 'danger'],
        AUCTION_TYPE_UNIQUE_BIDDER => ['color_class' => 'success'],
        AUCTION_TYPE_VICKREY_BIDDER => ['color_class' => 'primary'],
    ],
    'dispute_type' => [
        DISPUTE_TYPE_AUCTION_ISSUE => ['color_class' => 'bg-purple text-white', 'text' => 'Auction Issue'],
        DISPUTE_TYPE_SELLER_ISSUE => ['color_class' => 'bg-pink text-white', 'text' => 'Seller Issue'],
        DISPUTE_TYPE_SHIPPING_ISSUE => ['color_class' => 'bg-info text-white', 'text' => 'Shipping Issue'],
        DISPUTE_TYPE_OTHER_ISSUE => ['color_class' => 'bg-blue text-white', 'text' => 'Other Issue'],
    ],
    'dispute_status' => [
        DISPUTE_STATUS_PENDING => ['color_class' => 'bg-warning text-white', 'text' => 'Pending'],
        DISPUTE_STATUS_ON_INVESTIGATION => ['color_class' => 'bg-blue text-white', 'text' => 'On Investigation'],
        DISPUTE_STATUS_SOLVED => ['color_class' => 'bg-success text-white', 'text' => 'Solved'],
        DISPUTE_STATUS_DECLINED => ['color_class' => 'bg-danger text-white', 'text' => 'Declined'],
    ],
    'payment_status' => [
        PAYMENT_STATUS_PENDING => ['color_class' => 'warning', 'text' => 'Pending'],
        PAYMENT_STATUS_COMPLETED => ['color_class' => 'success', 'text' => 'Completed'],
        PAYMENT_STATUS_CANCELED => ['color_class' => 'danger', 'text' => 'Canceled'],
        PAYMENT_STATUS_FAILED => ['color_class' => 'danger', 'text' => 'Failed'],
        PAYMENT_STATUS_PROCESSING => ['color_class' => 'warning', 'text' => 'Processing'],
        PAYMENT_STATUS_REVIEWING => ['color_class' => 'info', 'text' => 'Reviewing'],
    ],

    'layout_types' => [
        AUCTION_LAYOUT_TYPE_RECENT_AUCTION => ['color_class' => 'bg-purple text-white', 'text' => 'Recent Auction'],
        AUCTION_LAYOUT_TYPE_POPULAR_AUCTION => ['color_class' => 'bg-pink text-white', 'text' => 'Popular Auction'],
        AUCTION_LAYOUT_TYPE_HIGHEST_BIDDER_AUCTION => ['color_class' => 'bg-teal text-white', 'text' => 'Highest Bid'],
        AUCTION_LAYOUT_TYPE_BLIND_BIDDER_AUCTION => ['color_class' => 'bg-blue text-white', 'text' => 'Blind Bid'],
        AUCTION_LAYOUT_TYPE_UNIQUE_BIDDER_AUCTION => ['color_class' => 'bg-indigo text-white', 'text' => 'Unique Bid'],
        AUCTION_LAYOUT_TYPE_VICKREY_BIDDER_AUCTION => ['color_class' => 'bg-success text-white', 'text' => 'Vickrey Bid'],
        AUCTION_LAYOUT_TYPE_LOWEST_PRICE_AUCTION => ['color_class' => 'bg-info text-white', 'text' => 'Lowest Price'],
        AUCTION_LAYOUT_TYPE_HIGHEST_PRICE_AUCTION => ['color_class' => 'bg-warning text-white', 'text' => 'Highest Price'],
    ],

    'product_claim_status' => [
        AUCTION_PRODUCT_CLAIM_STATUS_ON_SHIPPING => ['color_class' => 'bg-warning text-white', 'text' => 'On Shipping'],
        AUCTION_PRODUCT_CLAIM_STATUS_DISPUTED => ['color_class' => 'bg-warning text-white', 'text' => 'Disputed'],
        AUCTION_PRODUCT_CLAIM_STATUS_DELIVERED => ['color_class' => 'bg-success text-white', 'text' => 'Delivered'],
        AUCTION_PRODUCT_CLAIM_STATUS_NOT_DELIVERED_YET => ['color_class' => 'bg-custom-gray color-666', 'text' => 'Not Delivered Yet'],

    ],
    'auction_status' => [
        AUCTION_STATUS_DRAFT => ['color_class' => 'warning', 'text' => 'Draft'],
        AUCTION_STATUS_RUNNING => ['color_class' => 'success', 'text' => 'Running'],
        AUCTION_STATUS_COMPLETED => ['color_class' => 'info', 'text' => 'Completed'],
    ],
    'shipping_type' => [
        SHIPPING_TYPE_FREE => ['color_class' => 'bg-success', 'text' => 'Free'],
        SHIPPING_TYPE_PAID => ['color_class' => 'bg-danger', 'text' => 'Paid'],
    ],
    'payment_methods' => [
        PAYMENT_METHOD_PAYPAL => ['color_class' => 'bg-custom-gray color-666', 'text' => 'PayPal'],
        PAYMENT_METHOD_BANK => ['color_class' => 'bg-custom-gray color-666', 'text' => 'Bank Payment'],
    ],

];
