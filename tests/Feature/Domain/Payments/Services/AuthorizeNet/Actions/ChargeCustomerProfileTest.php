<?php


namespace Tests\Feature\Domain\Payments\Services\AuthorizeNet\Actions;


use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Payments\Models\PaymentMethod;
use Domain\Payments\Services\AuthorizeNet\Actions\ChargeCustomerProfile;
use Domain\Payments\Services\AuthorizeNet\Actions\MockApiResponse;
use Domain\Payments\Services\AuthorizeNet\DataObjects\TransactionDO;
use Domain\Payments\Services\AuthorizeNet\ValueObjects\ChargeRequestVO;
use Domain\Payments\Services\AuthorizeNet\ValueObjects\CustomerPaymentProfileVO;
use net\authorize\api\contract\v1\CreateTransactionResponse;
use net\authorize\api\contract\v1\TransactionResponseType;
use Tests\Feature\Domain\Payments\Services\AuthorizeNet\Traits\UsesAuthorizeNetApiClient;

class ChargeCustomerProfileTest extends \Tests\TestCase
{
    use UsesAuthorizeNetApiClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentMethod = PaymentMethod::firstOrFactory();
        $this->paymentProfile = CimPaymentProfile::firstOrFactory();
    }

    /** @test */
    public function can_charge_profile()
    {
        $this->initAuthNetClient();

        $this->mockExecuteApi()
            ->once()
            ->andReturn(MockApiResponse::now(
                new CreateTransactionResponse,
                <<<EOD
{"transactionResponse":{"responseCode":"1","authCode":"000000","avsResultCode":"Y","cvvResultCode":"P","cavvResultCode":"2","transId":"40109582555","refTransID":"","transHash":"","testRequest":"0","accountNumber":"XXXX0015","accountType":"MasterCard","messages":[{"code":"1","description":"This transaction has been approved."}],"transHashSha2":"","profile":{"customerProfileId":"508168897","customerPaymentProfileId":"513137419"},"SupplementalDataQualificationIndicator":0,"networkTransId":"00000000000000000000000"},"refId":"TEST-REF-001","messages":{"resultCode":"Ok","message":[{"code":"I00001","text":"Successful."}]}}
EOD
            ));

        $action = ChargeCustomerProfile::run(
            new ChargeRequestVO(
                $this->authNetApiClient,
                $this->authNetApiClient->transactionRequest()
                    ->setRefId('TEST-REF-001'),
                1.99
            ),
            (new CustomerPaymentProfileVO(
                $this->testProfileId,
                $this->testPaymentProfileId
            ))->getCustomerProfilePaymentType()
        );

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
