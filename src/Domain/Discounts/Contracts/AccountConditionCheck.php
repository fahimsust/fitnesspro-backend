<?php

namespace Domain\Discounts\Contracts;

use Illuminate\Support\Facades\Auth;
use Support\Traits\RequiresAccount;
use Symfony\Component\HttpFoundation\Response;

abstract class AccountConditionCheck extends DiscountConditionCheck
{
    use RequiresAccount;

    protected function isLoggedIn(): bool
    {
        return Auth::check();
    }

    protected function checkUserIsLoggedIn(): static
    {
        if ($this->isLoggedIn()) {
            return $this;
        }

        $this->failed(
            __('User not logged in'),
            Response::HTTP_FORBIDDEN
        );
    }
}
