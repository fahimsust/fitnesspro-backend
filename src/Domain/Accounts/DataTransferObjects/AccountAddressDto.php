<?php

namespace Domain\Accounts\DataTransferObjects;

use App\Api\Addresses\Requests\AddressRequest;
use Domain\Accounts\Models\Account;
use Domain\Addresses\Actions\CreateAddressFromAddressData;
use Domain\Addresses\Models\Address;
use Support\Dtos\AddressDto;

class AccountAddressDto extends AddressDto
{
    public ?Account $account;
    public ?int $account_id;

    public ?Address $address;
    public ?AddressDto $addressData;
    public ?int $address_id;

    public bool $is_billing = true;
    public bool $is_shipping = true;

    public bool $status = true;

    public static function fromRequest(AddressRequest $request): static
    {
        return self::from(
            [
                'addressData' => AddressDto::fromRequest($request),
                'account_id' => $request->account_id,
                'is_billing' => $request->is_billing ?? true,
                'is_shipping' => $request->is_shipping ?? true,
            ]
        );
    }

    public static function fromAccount(
        Account $account,
        bool $isBilling = true,
        bool $isShipping = true
    ): static {
        return self::from([
            'account' => $account,
            'is_billing' => $isBilling,
            'is_shipping' => $isShipping,
        ]);
    }

    public function setAccount(Account $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function toModelArray(): array
    {
        return [
            'account_id' => $this->toAccountId(),
            'is_billing' => $this->is_billing,
            'is_shipping' => $this->is_shipping,
            'address_id' => $this->toAddressId(),
            'status' => $this->status,
        ];
    }

    protected function toAccountId()
    {
        return $this->account?->id
            ?? $this->account_id;
    }

    protected function toAddressId(): int
    {
        return $this->address?->id
            ?? $this->addressData
                ? CreateAddressFromAddressData::run($this->addressData)->id
                : $this->address_id;
    }

    protected function toLabel(?string $backupLabel = null): string
    {
        return parent::toLabel('New Account Address');
    }
}
