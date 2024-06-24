<?php

namespace Domain\Sites\Actions;

use Domain\Messaging\Enums\SiteMessageKeys;
use Domain\Sites\Models\Site;
use Support\Contracts\AbstractAction;

class BuildSiteMessageKeysValuesFromModel extends AbstractAction
{
    public array $keys = [];

    public function __construct(
        public Site $site
    )
    {
    }

    public function execute(): array
    {
        collect(SiteMessageKeys::cases())
            ->each(
                fn(SiteMessageKeys $key) => $this->addKey($key->name, $this->site->{$key->value})
            );

        return $this->keys;
    }

    protected function addKey(string $key, string $value): static
    {
        $this->keys[$key] = $value;

        return $this;
    }
}
