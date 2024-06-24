<?php

namespace Domain\Accounts\Actions;

use Domain\Accounts\Models\Account;
use Domain\Messaging\Enums\AccountMessageKeys;
use Support\Contracts\AbstractAction;

class BuildAccountMessageKeysValuesFromModel extends AbstractAction
{
    public array $keys = [];

    public function __construct(
        public Account $account
    )
    {
    }

    public function execute(): array
    {
        collect(AccountMessageKeys::cases())
            ->each(
                fn(AccountMessageKeys $key) => $this->addKey($key->name, $this->account->{$key->value})
            );

        $url = Account::url();
        $this->keys['ACCOUNT_LOGIN_LINK_HTML'] = '<a href="' . $url . '">' . $url . '</a>';
        $this->keys['ACCOUNT_LOGIN_LINK'] = $url;

        return $this->keys;
    }

    protected function addKey(string $key, ?string $value): static
    {
        $this->keys[$key] = $value ?? '';

        return $this;
    }
}
