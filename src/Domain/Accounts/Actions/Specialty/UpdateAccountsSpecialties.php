<?php

namespace Domain\Accounts\Actions\Specialty;

use Domain\Accounts\Models\Account;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateAccountsSpecialties
{
    use AsObject;

    public Account $account;

    public function handle(
        array $specialties,
        Account $account,
        bool $approve = true
    ) {
        RemoveAccountSpecialties::run();
        $account->specialties()->createMany(
            array_map(fn ($specialty) => [
                'specialty_id' => $specialty,
                'approved' => $approve,
            ], $specialties)
        );
    }
}
