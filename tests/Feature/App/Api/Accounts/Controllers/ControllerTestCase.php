<?php

namespace Tests\Feature\App\Api\Accounts\Controllers;

use Tests\Feature\Traits\HasTestAccount;
use Tests\TestCase;

abstract class ControllerTestCase extends TestCase
{
    use HasTestAccount;
}
