<?php

namespace Tests\Unit\Domain\Accounts\Actions;

use App\Api\Accounts\Requests\Registration\CreateAccountFromBasicInfoRequest;
use Domain\Accounts\Actions\CreateAccountFromBasicInfo;
use Domain\Accounts\Models\Account;
use Domain\Accounts\ValueObjects\BasicAccountInfoData;
use Tests\TestCase;


class CreateAccountFromBasicInfoTest extends TestCase
{
    /** @test */
    public function can_create_account_from_basic_info()
    {
        $account = CreateAccountFromBasicInfo::run(
            BasicAccountInfoData::fromRequest(
                $this->formRequestFactory(
                    CreateAccountFromBasicInfoRequest::class,
                    "POST"
                )
            )
        );

        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals(Account::first()->email, $account->email);
        $this->assertEquals(1, Account::count());
    }
}
