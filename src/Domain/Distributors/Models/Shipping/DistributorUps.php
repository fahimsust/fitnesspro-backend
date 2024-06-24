<?php

namespace Domain\Distributors\Models\Shipping;

use Domain\Orders\Actions\Services\Shipping\Ups\ConstructClientFromDistributorService;
use Domain\Orders\Contracts\ShippingServiceModel;
use Domain\Orders\Services\Shipping\Ups\Client;
use Domain\Orders\Services\Shipping\Ups\Dtos\Token;
use Domain\Orders\Services\Shipping\Ups\Enums\Modes;
use Domain\Orders\Services\Shipping\Ups\Enums\RateTypes;

class DistributorUps
    extends DistributorShippingGateway
    implements ShippingServiceModel
{
    public static function config(): array
    {
        return [
            'test_mode' => 'boolean',
            'label_creation' => 'boolean',
            'rate_type' => RateTypes::class,
        ];
    }

    public static function credentials(): array
    {
        return [
            'test' => [
                'auth_code' => 'string',
                'token' => Token::class,
                'ups_account_number' => 'string',
            ],
            'live' => [
                'auth_code' => 'string',
                'token' => Token::class,
                'ups_account_number' => 'string',
            ]
        ];
    }

    public function rateType(): RateTypes
    {
        return RateTypes::from($this->getConfig('rate_type'));
    }

    public function token(?Modes $mode = null): ?Token
    {
        $tokenArray = $this->getCredential('token', $mode ?? $this->currentMode());

        if(!$tokenArray) {
            return null;
        }

        return new Token(
            ...$tokenArray
        );
    }

    public function client(?Modes $mode = null): Client
    {
        return ConstructClientFromDistributorService::now(
            $this,
            $mode ?? $this->currentMode()
        );
    }

    public function getCredential(string $key, ?Modes $mode = null): mixed
    {
        if (!$mode) {
            $mode = $this->currentMode();
        }

        return \Arr::get(
            $this->credentials,
            $mode->value . '.' . str_replace('->', '.', $key)
        ) ?? null;
    }

    private function currentMode(): Modes
    {
        return $this->getConfig('test_mode')
            ? Modes::Test
            : Modes::Live;
    }
}
