<?php

namespace Database\Seeders\Domain\Accounts;

use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder{
    public function run()
    {
        return \Domain\Accounts\Models\Account::factory([

        ])->create();
    }
}
