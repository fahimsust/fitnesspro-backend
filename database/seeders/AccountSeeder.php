<?php

namespace Database\Seeders;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\AdminUsers\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(['email' => 'john@782media.com', 'password' => Hash::make('test')]);
        //MembershipLevel::factory(10)->create();
    }
}
