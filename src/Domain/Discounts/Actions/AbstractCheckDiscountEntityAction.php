<?php

namespace Domain\Discounts\Actions;

use Domain\Accounts\Models\Account;
use Domain\Discounts\Contracts\CanBeCheckedForDiscount;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Orders\Models\Carts\Cart;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Traits\HasExceptionCollection;

abstract class AbstractCheckDiscountEntityAction
{
    use AsObject,
        HasExceptionCollection;

    public bool $success = false;

    public function __construct(
        public DiscountCheckerData     $checkerData,
        public CanBeCheckedForDiscount $discountEntity,
        public ?Cart                   $cart = null,
        public ?Account                $account = null,
    ) {
    }

    abstract public function handle(bool $throwOnFailure = true): bool;
}
