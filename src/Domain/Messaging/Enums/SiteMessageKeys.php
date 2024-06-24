<?php

namespace Domain\Messaging\Enums;

enum SiteMessageKeys: string
{
    case SITE_URL = 'url';
    case SITE_NAME = 'name';
    case SITE_EMAIL = 'email';
    case SITE_DOMAIN = 'domain';
    case SITE_PHONE = 'phone';
}
