<?php

namespace Domain\AdminUsers\Enums;

enum AdminEmailSentStatuses: string
{
    case Sending = 'sending';
    case Sent = 'sent';
    case Failed = 'failed';
}
