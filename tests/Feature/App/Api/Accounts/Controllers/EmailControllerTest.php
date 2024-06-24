<?php

namespace Tests\Feature\App\Api\Accounts\Controllers;

use Domain\Accounts\Models\Account;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use function route;
use Tests\TestCase;

class EmailControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->apiTestToken();
    }

    /**
     * can_update_account_email_address
     *
     * @test
     */
    public function can_update_account_email_address()
    {
        $currentEmail = $this->account->email;
        $updateEmail = 'jane.doe@mail.com';

        $this->assertNotEquals($updateEmail, $currentEmail); //make sure the email we're updating to does not match current email

        $response = $this->postJson(route('mobile.account.email.store', $this->account), [
            'new_email' => $updateEmail,
        ])->assertStatus(Response::HTTP_CREATED);

        $this->assertEquals($updateEmail, $response['email']);
        $this->assertEquals($updateEmail, $this->account->fresh()->email); //this isn't necessary needed, but double check database doesn't hurt
    }

    /** @test */
    public function invalid_email_throws_exception_as_expected()
    {
        $this->withoutExceptionHandling();

        $currentEmail = $this->account->email;
        $updateEmail = 'jane.doemail.com';

        $this->expectException(ValidationException::class);

        try {
            $this->postJson(route('mobile.account.email.store', $this->account), ['new_email' => $updateEmail]);
        } finally {
            $this->assertDatabaseHas('accounts', ['email' => $currentEmail]); //Certify that email address didn't Update
        }
    }

    /** @test */
    public function try_to_update_a_non_unique_email_address()
    {
        $this->withoutExceptionHandling();

        $currentEmail = $this->account->email;
        $newAccount = Account::factory()->create();

        $this->assertNotEquals($currentEmail, $newAccount->email);
        $this->expectException(ValidationException::class);

        $this->postJson(route('mobile.account.email.store', $this->account), ['new_email' => $newAccount->email]);
        $this->assertCount(1, Account::whereEmail($newAccount->email)); //Certify that email address didn't Update
    }
}
