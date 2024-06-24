<?php

namespace Domain\Payments\Services\AuthorizeNet\Actions;

use Domain\Payments\Services\AuthorizeNet\Exceptions\ApiException;
use Domain\Payments\Services\AuthorizeNet\Exceptions\EmptyResponseException;
use net\authorize\api\contract\v1\ANetApiResponseType;
use net\authorize\api\contract\v1\TransactionResponseType;
use Support\Contracts\AbstractAction;

class HandleCreateTransactionResponse extends AbstractAction
{
    private ?TransactionResponseType $transactionResponse;

    public function __construct(
        public AnetApiResponseType $response
    )
    {
        if ($this->response == null)
            throw new EmptyResponseException();
    }

    public function result(): TransactionResponseType
    {
        return $this->transactionResponse;
    }

    public function execute(): static
    {
        if ($this->response->getMessages()->getResultCode() != "Ok")
            $this->handleResponseError();

        $this->transactionResponse = $this->response->getTransactionResponse();

        if ($this->transactionResponse == null || $this->transactionResponse->getMessages() == null)
            $this->handleResponseError();

        return $this;
    }

    protected function handleResponseError()
    {
        $transactionResponse = $this->response->getTransactionResponse();

        if ($transactionResponse?->getErrors() == null) {
            $errorCode = $this->response->getMessages()->getMessage()[0]->getCode();

            throw new ApiException(
                "({$errorCode}) " .
                $this->response->getMessages()->getMessage()[0]->getText(),
                is_string($errorCode) ? 500 : $errorCode
            );
        }

        $errorCode = $transactionResponse->getErrors()[0]->getErrorCode();

        throw new ApiException(
            "({$errorCode}) " .
            $transactionResponse->getErrors()[0]->getErrorText(),
            is_string($errorCode) ? 500 : $errorCode
        );
    }
}
