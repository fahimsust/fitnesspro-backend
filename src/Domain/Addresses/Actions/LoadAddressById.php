<?php

namespace Domain\Addresses\Actions;

use Domain\Addresses\Models\Address;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadAddressById extends AbstractAction
{
    public function __construct(
        public int  $addressId,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): Address
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return Cache::tags([
            'address-id-cache.' . $this->addressId,
        ])
            ->remember(
                'load-address-by-id.' . $this->addressId,
                60 * 5,
                fn() => $this->load()
            );
    }

    public function load(): Address
    {
        return Address::find($this->addressId)
            ?? throw new ModelNotFoundException(
                __("No address matching ID :id.", [
                    'id' => $this->addressId,
                ])
            );
    }
}
