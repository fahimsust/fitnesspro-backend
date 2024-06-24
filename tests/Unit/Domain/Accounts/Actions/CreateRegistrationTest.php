<?php

namespace Tests\Unit\Domain\Accounts\Actions;

use Domain\Accounts\Actions\Registration\CreateRegistration;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Registration\Registration;
use Domain\Sites\Models\Site;
use Tests\TestCase;


class CreateRegistrationTest extends TestCase
{
    /** @test */
    public function can_create_registration()
    {
        $account = Account::factory()->create();

        $registration = CreateRegistration::run(
            app(Site::class)->id,
            $account
        );

        $this->assertInstanceOf(Registration::class, $registration);
        $this->assertEquals($account->id, $registration->account_id);
        $this->assertEquals(1, $registration::count());
    }
}
