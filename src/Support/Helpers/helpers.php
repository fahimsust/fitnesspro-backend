<?php

use Domain\Accounts\Models\Account;
use Domain\Orders\Actions\Cart\GetCartFromSession;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

function site(): \Domain\Sites\Models\Site
{
    return resolve(\Domain\Sites\Models\Site::class);
}

function user(): Account|Authenticatable|null
{
    return Auth::guard('web')?->user();
}

function cart(bool $createIfMissing = false): \Domain\Orders\Models\Carts\Cart
{
    if ($createIfMissing) {
        return GetCartFromSession::now(user());
    }

    return GetCartFromSession::throwIfMissing(user());
}
