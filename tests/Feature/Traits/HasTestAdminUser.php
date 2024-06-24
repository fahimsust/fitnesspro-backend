<?php

namespace Tests\Feature\Traits;

use Domain\Accounts\Actions\AuthenticateAccount;
use Domain\AdminUsers\Models\User;
use Illuminate\Support\Facades\Hash;

trait HasTestAdminUser
{
    protected User $user;

    protected string $password;

    protected function createAndAuthAdminUser(): User
    {
        $this->actingAs($this->createTestAdminUser(), 'admin');

        return $this->user;
    }

    protected function createTestAdminUser(): User
    {
        $email = 'test@test.com';
        $this->password = 'test_pass';

        return $this->user = User::factory([
            'email' => $email,
            'password' => Hash::make($this->password),
        ])->create();
    }
}
