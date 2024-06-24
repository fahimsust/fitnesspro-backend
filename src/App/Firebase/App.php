<?php

namespace App\Firebase;

use Illuminate\Contracts\Auth\Authenticatable;

class App implements Authenticatable
{

    public string $id;
    private string $appId;

    public function __construct($anonid)
    {
        $this->appId = $anonid; //anonymous firebase id
        $this->id = $this->appId;
    }

    public function getAuthIdentifierName()
    {
        return 'app';
    }

    public function getAuthIdentifier()
    {
        return $this->appId;
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
