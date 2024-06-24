<?php

namespace Domain\Reports\Enums;


enum ReportReady: int
{
    case WAITING_IN_QUEUE = 0;
    case PROCESSING = 1;
    case COMPLETED = 2;

    public function label(): string
    {
        return match ($this) {
            self::WAITING_IN_QUEUE => __('Waiting in Queue'),
            self::PROCESSING => __('Processing'),
            self::COMPLETED => __('Completed')
        };
    }
}
