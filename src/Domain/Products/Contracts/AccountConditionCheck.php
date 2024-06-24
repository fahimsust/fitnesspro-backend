<?php

namespace Domain\Products\Contracts;

use Illuminate\Support\Facades\Auth;
use Support\Traits\RequiresAccount;
use Symfony\Component\HttpFoundation\Response;

abstract class AccountConditionCheck extends OrderingConditionCheck
{
    use RequiresAccount;

    protected function isLoggedIn(): bool
    {
        return Auth::guard('web')->check()
            && Auth::guard('web')->user()->id === $this->account->id;
    }

    protected function checkUserIsLoggedIn(): static
    {
        if ($this->isLoggedIn()) {
            return $this;
        }

        $this->failed(__('You must be logged in to order this item'), Response::HTTP_FORBIDDEN);
    }
}
