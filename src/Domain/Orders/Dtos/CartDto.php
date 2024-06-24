<?php

namespace Domain\Orders\Dtos;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Orders\Enums\Cart\CartStatuses;
use Domain\Orders\Models\Carts\Cart;
use Domain\Sites\Models\Site;
use Spatie\LaravelData\Data;

class CartDto extends Data
{
    public function __construct(
        public Site         $site,
        public CartStatuses $status = CartStatuses::ACTIVE,
        public ?Account     $account = null,
        public bool $isRegistration = false,
    )
    {
    }

    public static function fromRegistration(Registration $registration): static
    {
        return new static(
            site: $registration->siteCached(),
            status: $registration->status->toCartStatus(),
            account: $registration->accountCached(),
            isRegistration: true,
        );
    }

    public function toModel(): Cart
    {
        return Cart::create($this->toModelArray());
    }

    public function toModelArray(): array
    {
        return [
            'site_id' => $this->site->id,
            'status' => $this->status,
            'account_id' => $this->account?->id,
            'is_registration' => $this->isRegistration,
        ];
    }
}
