<?php

namespace Tests\Feature\App\Api;

use Illuminate\Support\Str;
use Tests\Feature\Traits\HasTestAccount;
use Tests\TestCase;

class FirebaseAuthTest extends TestCase
{
    use HasTestAccount;

    /** @test */
    public function can_authenticate_with_user()
    {
        $account = $this->createAndAuthAccount();

        $this->assertIsObject($account);
        $this->assertGreaterThan(0, $account->id);
    }

    /** @test */
    public function can_auth_and_generate_custom_token()
    {
        $account = $this->createAndAuthAccount();

        $auth = app('firebase.auth');
        $customToken = $auth->createCustomToken((string) $account->id, ['is_account' => true]);

        $this->assertIsObject($account);
        $this->assertGreaterThan(0, Str::length($customToken->toString()));
    }
}
