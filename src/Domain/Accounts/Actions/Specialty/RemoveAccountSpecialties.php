<?php

namespace Domain\Accounts\Actions\Specialty;

use Domain\Accounts\Models\Account;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveAccountSpecialties
{
    use AsObject;

    public Account $account;

    public function handle(
        Account $account,
    ) {
        $account->specialties()->delete();
    }
}
