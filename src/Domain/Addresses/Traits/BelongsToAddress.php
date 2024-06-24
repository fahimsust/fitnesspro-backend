<?php

namespace Domain\Addresses\Traits;

use Domain\Addresses\Actions\LoadAddressById;
use Domain\Addresses\Models\Address;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

trait BelongsToAddress
{
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function addressCached(): Address
    {
        return $this->address ??= LoadAddressById::now($this->address_id);
    }

    public function country(): HasOneThrough
    {
        return $this->hasOneThrough(
            Country::class,
            Address::class,
        );
    }

    public function countryCached(): Country
    {
        return $this->addressCached()->countryCached();
    }

    public function stateProvince(): HasOneThrough
    {
        return $this->hasOneThrough(
            StateProvince::class,
            Address::class,
        );
    }

    public function stateProvinceCached(): StateProvince
    {
        return $this->addressCached()->stateProvinceCached();
    }
}
