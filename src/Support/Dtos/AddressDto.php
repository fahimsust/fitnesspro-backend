<?php

namespace Support\Dtos;

use App\Api\Addresses\Requests\AddressRequest;
use Domain\Addresses\Models\Address;
use Domain\Locales\Actions\LoadCountryByIdFromCache;
use Domain\Locales\Actions\LoadStateByIdFromCache;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Spatie\LaravelData\Data;

class AddressDto extends Data
{
    public ?string $label;

    public string $first_name;
    public string $last_name;
    public string $address_1;
    public ?string $address_2;
    public string $city;
    public ?string $company;

    public ?int $state_id;
    public ?string $stateAbbreviation = null;

    public ?int $country_id;
    public ?string $countryAbbreviation;

    public string $postal_code;

    public string $phone;
    public string $email;

    public bool $is_residential = true;

    private ?Country $country = null;
    private ?StateProvince $state = null;

    public static function fromRequest(AddressRequest $request): static
    {
        return self::from(
            [
                'company' => $request->company,
                'first_name' => $request->first_name ?? '',
                'last_name' => $request->last_name ?? '',
                'address_1' => $request->address_1,
                'address_2' => $request->address_2 ?? '',
                'city' => $request->city,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'postal_code' => $request->postal_code,
                'phone' => $request->phone,
                'email' => $request->email,
                'is_residential' => $request->is_residential ?? true,
                'label' => $request->label,
            ]
        );
    }

    public static function fromModel(Address $address): self
    {
        return self::from(
            [
                'company' => $address->company,
                'first_name' => $address->first_name,
                'last_name' => $address->last_name,
                'address_1' => $address->address_1,
                'address_2' => $address->address_2,
                'city' => $address->city,
                'country_id' => $address->country_id,
                'state_id' => $address->state_id,
                'postal_code' => $address->postal_code,
                'phone' => $address->phone,
                'email' => $address->email,
                'is_residential' => $address->is_residential,
                'label' => $address->label,
            ]
        );
    }

    public function toModelArray(): array
    {
        return [
            'label' => $this->toLabel(),
            'company' => $this->company,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'city' => $this->city,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'postal_code' => $this->postal_code,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_residential' => $this->is_residential,
        ];
    }

    protected function toLabel(?string $backupLabel = null): string
    {
        return match (true) {
            $this->label !== null => $this->label,
            $backupLabel !== null => $backupLabel,
            default => 'New Address'
        };
    }

    public function setCountryModel(): Country
    {
        return $this->country ??= LoadCountryByIdFromCache::now($this->country_id);
    }

    public function loadCountry(): static
    {
        $this->setCountryModel();

        $this->countryAbbreviation = $this->country->abbreviation;

        return $this;
    }

    public function setStateModel(): StateProvince
    {
        return $this->state ??= LoadStateByIdFromCache::now($this->state_id);
    }

    public function loadState(): static
    {
        $this->setStateModel();

        $this->stateAbbreviation = $this->state->abbreviation;

        return $this;
    }
}
