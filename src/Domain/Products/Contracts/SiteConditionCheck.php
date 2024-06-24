<?php

namespace Domain\Products\Contracts;

use Support\Traits\RequiresSite;

abstract class SiteConditionCheck extends OrderingConditionCheck
{
    use RequiresSite;
}
