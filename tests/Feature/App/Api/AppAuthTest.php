<?php

namespace Tests\Feature\App\Api;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AppAuthTest extends TestCase
{


    protected function setUp(): void
    {
        parent::setUp();

        $this->appApiTestToken();
    }

    /** @test */
    public function cannot_access_account_specific_api_endpoints()
    {
        $this->withoutExceptionHandling()
            ->expectException(AuthenticationException::class);
        $this->createTestAccount();

        $response = $this->getJson(route('mobile.account.show', $this->account->id));
    }

    /** @test */
    public function can_access_non_account_specific_endpoints()
    {
        $this->withoutExceptionHandling()
            ->expectException(ValidationException::class);

        $this->postJson(route('mobile.support.store'));
    }
}
