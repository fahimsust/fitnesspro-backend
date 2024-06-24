<?php

return [
    'dont_allow_duplicate_email' => env('DONT_ALLOW_DUPLICATE_EMAILS', 1),
    'blacklist_email_tld'=>env('BLACKLIST_REGISTRATION_EMAIL_TLD',[]),
    'blacklist_ip'=>env('BLACKLIST_REGISTRATION_IP',[]),
    'account_use_username'=>env('ACCOUNT_USE_USERNAME',false),
    'account_link_affiliate'=>env('ACCOUNT_LINK_AFFILIATE',true),
];
