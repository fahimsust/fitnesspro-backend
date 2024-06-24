<?php

namespace Domain\Affiliates\Actions;

use Domain\Affiliates\Models\Affiliate;
use Domain\Messaging\Enums\AffiliateMessageKeys;
use Support\Contracts\AbstractAction;

class BuildAffiliateMessageKeysValuesFromModel extends AbstractAction
{
    public array $keys = [];

    public function __construct(
        public Affiliate $affiliate
    ) {
    }

    public function execute(): array
    {
        collect(AffiliateMessageKeys::cases())
            ->each(
                fn (AffiliateMessageKeys $key) => $this->addKey($key->name, $this->affiliate->{$key->value})
            );

        return $this->keys;
    }

    protected function addKey(string $key, ?string $value): static
    {
        $this->keys[$key] = $value ?? '';

        return $this;
    }
}
