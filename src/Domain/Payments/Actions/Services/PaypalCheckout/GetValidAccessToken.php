<?php

namespace Domain\Payments\Actions\Services\PaypalCheckout;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Services\PaypalCheckout\DataObjects\AccessToken;
use Domain\Payments\Services\PaypalCheckout\Enums\PaypalModes;
use Support\Contracts\AbstractAction;

class GetValidAccessToken extends AbstractAction
{
    public function __construct(
        public PaymentAccount $account,
        public PaypalModes    $mode
    )
    {
    }

    public function execute(): string
    {
        $token = $this->getToken();

        if ($token && !$token->isExpired()) {
            return $token->access_token;
        }

        return GenerateNewAccessToken::now(
            $this->account,
            $this->mode
        );
    }

    private function getToken(): ?AccessToken
    {
        return GetAccessTokenDataFromPaymentAccount::now(
            $this->account,
            $this->mode
        );
    }
}
