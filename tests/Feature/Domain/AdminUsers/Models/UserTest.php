<?php

namespace Tests\Feature\Domain\AdminUsers\Models;

use Domain\AdminUsers\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
}
