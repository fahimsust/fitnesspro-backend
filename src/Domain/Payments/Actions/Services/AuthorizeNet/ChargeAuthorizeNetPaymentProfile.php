<?php

namespace Domain\Payments\Actions\Services\AuthorizeNet;

use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Services\AuthorizeNet\Actions\ChargeCustomerProfile;
use Domain\Payments\Services\AuthorizeNet\Client;
use Domain\Payments\Services\AuthorizeNet\DataObjects\TransactionDO;
use Domain\Payments\Services\AuthorizeNet\ValueObjects\ChargeRequestVO;
use Domain\Payments\Services\AuthorizeNet\ValueObjects\CustomerPaymentProfileVO;
use net\authorize\api\contract\v1\TransactionResponseType;
use Support\Contracts\AbstractAction;

class ChargeAuthorizeNetPaymentProfile extends AbstractAction
{
    private TransactionResponseType $transactionResponse;
    private TransactionDO $transactionDo;

    public function __construct(
        public PaymentAccount    $account,
        public CimPaymentProfile $paymentProfile,
        public string            $orderId,
        public string            $amount
    )
    {
    }

    public function result(): TransactionDO
    {
        return $this->transactionDo;
    }

    public function execute(): static
    {
        $client = (new Client(
            $this->account->login_id,
            $this->account->transaction_key
        ))
            ->liveMode(!$this->account->use_test);

        $this->transactionDo = TransactionDO::fromTransactionResponseType(
            $this->transactionResponse = ChargeCustomerProfile::run(
                new ChargeRequestVO(
                    $client,
                    $client->transactionRequest()
                        ->setRefId($this->orderId),
                    $this->amount
                ),
                (new CustomerPaymentProfileVO(
                    $this->paymentProfile->profile->authnet_profile_id,
                    $this->paymentProfile->authnet_payment_profile_id
                ))->getCustomerProfilePaymentType()
            )->response()
        );

        return $this;
    }
}
