<?php


namespace Tests\Feature\Domain\Payments\Actions\AuthorizeNet;


use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Payments\Actions\Services\AuthorizeNet\ChargeAuthorizeNetPaymentProfile;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Payments\Services\AuthorizeNet\Actions\MockApiResponse;
use Domain\Payments\Services\AuthorizeNet\Exceptions\ApiException;
use net\authorize\api\contract\v1\CreateTransactionResponse;
use Tests\Feature\Domain\Payments\Services\AuthorizeNet\Traits\UsesAuthorizeNetApiClient;

class ChargeAuthorizeNetPaymentProfileTest extends \Tests\TestCase
{
    use UsesAuthorizeNetApiClient;

    private CimPaymentProfile $paymentProfile;
    private PaymentMethod $paymentMethod;
    private PaymentAccount $paymentAccount;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentAccount = PaymentAccount::firstOrFactory([
            'login_id' => '2s5Ra8BcZL',
            'transaction_key' => '9xwKUS277c5pTR47',
            'use_test' => true
        ]);
        $this->paymentMethod = PaymentMethod::firstOrFactory();
        $this->paymentProfile = CimPaymentProfile::firstOrFactory();
    }

    /** @test */
    public function can()
    {
        $this->mockExecuteApi()
            ->once()
            ->andReturn(MockApiResponse::now(
                new CreateTransactionResponse,
                <<<EOD
{"transactionResponse":{"responseCode":"1","authCode":"000000","avsResultCode":"Y","cvvResultCode":"P","cavvResultCode":"2","transId":"40109582555","refTransID":"","transHash":"","testRequest":"0","accountNumber":"XXXX0015","accountType":"MasterCard","messages":[{"code":"1","description":"This transaction has been approved."}],"transHashSha2":"","profile":{"customerProfileId":"508168897","customerPaymentProfileId":"513137419"},"SupplementalDataQualificationIndicator":0,"networkTransId":"00000000000000000000000"},"refId":"TEST-REF-001","messages":{"resultCode":"Ok","message":[{"code":"I00001","text":"Successful."}]}}
EOD
            ));

        $this->paymentProfile->update([
            'cc_exp' => now()->addDays(60)
        ]);

        $transactionDto = ChargeAuthorizeNetPaymentProfile::now(
            $this->paymentAccount,
            $this->paymentProfile,
            "ORD001",
            "100"
        );

        $this->assertEquals('40109582555', $transactionDto->id());
//        dd($transactionDto);
    }

    /** @test */
    public function can_handle_failure()
    {
        $this->mockExecuteApi()
            ->once()
            ->andReturn(MockApiResponse::now(
                new CreateTransactionResponse,
                <<<EOD
{"transactionResponse":{"SupplementalDataQualificationIndicator":0},"refId":"ORD001","messages":{"resultCode":"Error","message":[{"code":"E00040","text":"Customer Profile ID or Customer Payment Profile ID not found."}]}}
EOD
            ));

        $this->expectException(ApiException::class);

        ChargeAuthorizeNetPaymentProfile::run(
            $this->paymentAccount,
            $this->paymentProfile,
            "ORD001",
            "100"
        );
    }
}
