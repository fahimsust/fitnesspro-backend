<?php

namespace Domain\Payments\Actions\Services\PaypalCheckout;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Services\PaypalCheckout\DataObjects\AccessToken;
use Domain\Payments\Services\PaypalCheckout\Enums\PaypalModes;
use Support\Contracts\AbstractAction;

class GetAccessTokenDataFromPaymentAccount extends AbstractAction
{
    public function __construct(
        public PaymentAccount $account,
        public PaypalModes    $mode
    )
    {
    }

    public function execute(): ?AccessToken
    {
        if(!$this->parseAccessToken()) {
            return null;
        }

        return AccessToken::fromApi(
            $this->parseAccessToken()
        );
    }

    protected function parseAccessToken(): ?array
    {
        return $this->account->credentials[$this->mode->value]['token'] ?? null;
    }
}
