<?php

namespace Domain\Payments\Actions\Services\PaypalCheckout;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Services\PaypalCheckout\Actions\GenerateNewAccessToken as ServiceGenerateNewAccessToken;
use Domain\Payments\Services\PaypalCheckout\Enums\PaypalModes;
use Support\Contracts\AbstractAction;

class GenerateNewAccessToken extends AbstractAction
{
    public function __construct(
        public PaymentAccount $account,
        public PaypalModes    $mode
    )
    {
    }

    public function execute(): string
    {
        $accessToken = ServiceGenerateNewAccessToken::now(
            ConstructClientFromPaymentAccount::now(
                account: $this->account,
                generateAccessToken: false
            )
        );

        $this->account->credentials($this->mode->value.'->token', $accessToken->toArray());

        return $accessToken->access_token;
    }
}
