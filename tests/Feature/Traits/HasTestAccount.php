<?php

namespace Tests\Feature\Traits;

use Domain\Accounts\Actions\AuthenticateAccount;
use Domain\Accounts\Models\Account;
use Illuminate\Support\Facades\Hash;

trait HasTestAccount
{
    protected string $password;

    protected function createAndAuthAccount()
    {
        $account = $this->_createTestAccount();

        return AuthenticateAccount::ByUser($account->user, $this->password);
    }

    protected function _createTestAccount($user = 'test_user', $email = 'test@test.com')
    {
        $this->password = 'test_pass';

        return Account::factory([
            'username' => $user,
            'email' => $email,
            'password' => Hash::make($this->password),
            'status_id' => 1,
        ])->create();
    }

    protected function seedAndCreateTestAccount()
    {
        $this->seed();

        return $this->createTestAccount();
    }
}
