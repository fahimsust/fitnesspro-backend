<?php

namespace Support\Traits\BelongsTo;

use Domain\Accounts\Actions\LoadAccountByIdFromCache;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToAccount
{
    private Account $accountCached;

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function accountCached(): ?Account
    {
        if (!$this->account_id) {
            return null;
        }

        if ($this->relationLoaded('account')) {
            return $this->account;
        }

        return $this->accountCached
            ??= LoadAccountByIdFromCache::now($this->account_id);
    }
}
