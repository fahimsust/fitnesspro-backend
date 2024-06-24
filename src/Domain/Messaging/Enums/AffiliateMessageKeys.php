<?php

namespace Domain\Messaging\Enums;

enum AffiliateMessageKeys: string
{
    case AFF_EMAIL = 'email';
    case AFF_NAME = 'name';
    case AFF_PASS = 'password';
    case AFF_ID = 'id';
    case AFF_PHONE = 'phone';
    case AFF_CREATED = 'created_at';
}
