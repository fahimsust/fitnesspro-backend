<?php

namespace Domain\Accounts\Actions;

use Domain\Accounts\Enums\AccountStatus;
use Domain\Accounts\Models\Account;
use Domain\Accounts\ValueObjects\BasicAccountInfoData;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\AbstractAction;

class CreateAccountFromBasicInfo
{
    use AsObject;

    public function handle(
        BasicAccountInfoData $info,
        ?int $account_id = null,
        AccountStatus        $status = AccountStatus::REGISTERING,
    ): Account {
        if ($account_id) {
            $account = Account::findOrFail($account_id);
            if ($account) {
                $account->update(
                    $info->except('password')->toArray()
                        + [
                            'password' => Hash::make($info->password),
                        ]
                );
            }
            return $account;
        }
        return Account::create(
            $info->except('password')->toArray()
                + [
                    'password' => Hash::make($info->password),
                    'status_id' => $status,
                ]
        );
    }
}
