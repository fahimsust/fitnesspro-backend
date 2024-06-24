<?php

namespace Domain\Accounts\QueryBuilders;

use Domain\Accounts\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Builder;

class RegistrationQueryBuilder extends Builder
{
    public function withAllRelations(): static
    {
        return $this->with([
            'account', 'affiliate', 'levelWithProduct', 'paymentMethod',
        ]);
    }

    public function isOpen(): static
    {
        return $this->whereStatus(RegistrationStatus::OPEN);
    }

    public function isComplete(): static
    {
        return $this->whereStatus(RegistrationStatus::CLOSE);
    }
}
