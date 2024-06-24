<?php

namespace Domain\Payments\Services\AuthorizeNet\Actions;

use Domain\Payments\Services\AuthorizeNet\DataObjects\TransactionDO;
use Domain\Payments\Services\AuthorizeNet\ValueObjects\ChargeRequestVO;
use net\authorize\api\contract\v1\TransactionRequestType;
use net\authorize\api\contract\v1\TransactionResponseType;
use net\authorize\api\controller\CreateTransactionController;
use Support\Contracts\AbstractAction;

abstract class AbstractChargeAction extends AbstractAction
{
    public TransactionRequestType $transactionRequest;
    public TransactionResponseType $transactionResponse;

    public string $transactionType = "authCaptureTransaction";

    public function __construct(
        public ChargeRequestVO $chargeRequest
    )
    {
        $this->initTransactionRequest();
    }

    public function successful(): bool
    {
        return $this->transactionResponse->getResponseCode() == "1";
    }

    protected function initTransactionRequest(): void
    {
        $this->transactionRequest = (new TransactionRequestType)
            ->setTransactionType($this->transactionType);
    }

    public function response(): TransactionResponseType
    {
        return $this->transactionResponse;
    }

    public function responseAsDto(): TransactionDO
    {
        return TransactionDO::fromTransactionResponseType(
            $this->response()
        );
    }

    protected function executeAndHandleResponse(): void
    {
        $this->transactionResponse = HandleCreateTransactionResponse::now(
            ExecuteApiCall::now(
                new CreateTransactionController($this->chargeRequest->request),
                $this->chargeRequest->client->environment
            )
        );
    }

    public function result(): TransactionResponseType
    {
        return $this->transactionResponse;
    }
}
