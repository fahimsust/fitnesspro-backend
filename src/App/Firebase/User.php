<?php

namespace App\Firebase;

use Domain\Accounts\Models\Account;
use Illuminate\Contracts\Auth\Authenticatable;

class User implements Authenticatable
{

    public mixed $id;
    private Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
        $this->id = $this->account->id;
    }

    public function getAuthIdentifierName()
    {
        return 'sub';
    }

    public function getAuthIdentifier()
    {
        return $this->account->id;
    }

    public function getAuthPassword()
    {
        throw new \Exception('No password for Firebase User');
    }

    public function getRememberToken()
    {
        throw new \Exception('No remember token for Firebase User');
    }

    public function setRememberToken($value)
    {
        throw new \Exception('No remember token for Firebase User');
    }

    public function getRememberTokenName()
    {
        throw new \Exception('No remember token for Firebase User');
    }
}
