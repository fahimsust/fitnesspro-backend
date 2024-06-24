<?php


namespace Tests\Feature\Domain\Payments\Services\AuthorizeNet\Actions;


use Domain\Payments\Services\AuthorizeNet\Actions\ChargeCard;
use Domain\Payments\Services\AuthorizeNet\Actions\MockApiResponse;
use Domain\Payments\Services\AuthorizeNet\DataObjects\TransactionDO;
use Domain\Payments\Services\AuthorizeNet\ValueObjects\ChargeRequestVO;
use Domain\Payments\Services\AuthorizeNet\ValueObjects\CreditCardVO;
use net\authorize\api\contract\v1\CreateTransactionResponse;
use net\authorize\api\contract\v1\TransactionResponseType;
use Tests\Feature\Domain\Payments\Services\AuthorizeNet\Traits\UsesAuthorizeNetApiClient;

class ChargeCardTest extends \Tests\TestCase
{
    use UsesAuthorizeNetApiClient;

    /** @test */
    public function can_charge_profile()
    {
        $this->initAuthNetClient();

        $this->mockExecuteApi()
            ->once()
            ->andReturn(MockApiResponse::now(
                new CreateTransactionResponse,
                <<<EOD
{"transactionResponse":{"responseCode":"1","authCode":"000000","avsResultCode":"Y","cvvResultCode":"P","cavvResultCode":"2","transId":"40109582700","refTransID":"","transHash":"","testRequest":"0","accountNumber":"XXXX0027","accountType":"Visa","messages":[{"code":"1","description":"This transaction has been approved."}],"transHashSha2":"","SupplementalDataQualificationIndicator":0,"networkTransId":"00000000000000000000000"},"refId":"TEST-REF-002","messages":{"resultCode":"Ok","message":[{"code":"I00001","text":"Successful."}]}}
EOD
            ));

        $action = (new ChargeCard(
            new ChargeRequestVO(
                $this->authNetApiClient,
                $this->authNetApiClient->transactionRequest()
                    ->setRefId('TEST-REF-002'),
                2.99
            ),
            (new CreditCardVO(
                '4007000000027',
                now()->addYears(3),
                '123'
            ))->getCreditCardType()
        ))
            ->execute();

        $transactionResponse = $action->response();

        $this->assertInstanceOf(TransactionResponseType::class, $transactionResponse);

        $transactionDto = $action->responseAsDto();

        $this->assertInstanceOf(TransactionDO::class, $transactionDto);
        $this->assertEquals($transactionResponse->getTransId(), $transactionDto->id());

//        dd($transactionResponse->getTransId(),
//            $transactionResponse->getAuthCode(),
//            $transactionResponse->getMessages(),
//            $transactionDto);
    }
}
