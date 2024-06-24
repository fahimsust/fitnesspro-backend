<?php

namespace Domain\Payments\Actions\Services\PaypalCheckout;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Services\PaypalCheckout\Client;
use Domain\Payments\Services\PaypalCheckout\Enums\PaypalModes;
use Support\Contracts\AbstractAction;

class ConstructClientFromPaymentAccount extends AbstractAction
{
    public function __construct(
        public PaymentAccount $account,
        public bool           $generateAccessToken = true
    )
    {
    }

    public function execute(): Client
    {
        $mode = $this->account->use_test
            ? PaypalModes::Sandbox
            : PaypalModes::Live;

        return new Client(
            clientId: $this->account->credentials[$mode->value]['client_id'],
            clientSecret: $this->account->credentials[$mode->value]['client_secret'],
            mode: $mode,
            accessToken: $this->generateAccessToken
                ? GetValidAccessToken::now($this->account, $mode)
                : $this->account->credentials[$mode->value]['token']['access_token'] ?? null
        );
    }
}
