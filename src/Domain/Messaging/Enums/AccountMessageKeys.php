<?php

namespace Domain\Messaging\Enums;

enum AccountMessageKeys: string
{
    case ACCOUNT_EMAIL = 'email';
    case ACCOUNT_FIRST_NAME = 'first_name';
    case CUSTOMER_FIRST_NAME = 'first_name';
    case ACCOUNT_LAST_NAME = 'last_name';
    case ACCOUNT_USER = 'username';
    case ACCOUNT_ID = 'id';
    case ACCOUNT_PHONE = 'phone';
    case ACCOUNT_CREATED = 'created_at';
    case ACCOUNT_LASTLOGIN = 'lastlogin_at';
    case ACCOUNT_STATUS_DISPLAY = 'account_status_display';
    case ACCOUNT_TYPE_DISPLAY = 'account_type_display';
    case ACCOUNT_ACTIVE_MEMBERSHIP_ID = 'active_membership_id';
    case ACCOUNT_ACTIVE_MEMBERSHIP_AMOUNTPAID = 'active_membership_amount_paid';
    case ACCOUNT_ACTIVE_MEMBERSHIP_SUBSCRIPTIONPRICE = 'active_membership_subscription_price';
    case ACCOUNT_ACTIVE_MEMBERSHIP_STARTDATE = 'active_membership_start_date';
    case ACCOUNT_ACTIVE_MEMBERSHIP_ENDDATE = 'active_membership_end_date';
    case ACCOUNT_ACTIVE_MEMBERSHIP_CREATED = 'active_membership_created';
    case ACCOUNT_ACTIVE_MEMBERSHIP_CANCELLED = 'active_membership_cancelled';
    case ACCOUNT_AFFILIATE_ID = 'affiliate_id';
}
