<?php

namespace Domain\Addresses\Models;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Addresses\QueryBuilders\AddressQuery;
use Domain\Future\GiftRegistry\GiftRegistry;
use Domain\Locales\Actions\LoadCountryByIdFromCache;
use Domain\Locales\Actions\LoadStateByIdFromCache;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Traits\HasModelUtilities;

class Address extends Model
{
    use HasFactory,
        HasModelUtilities,
        SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = [
        'label',
        'company',
        'first_name',
        'last_name',
        'address_1',
        'address_2',
        'city',
        'state_id',
        'country_id',
        'postal_code',
        'email',
        'phone',
        'is_residential',
        'resource_type',
        'resource_id',
    ];

    protected $casts = [
        'is_residential' => 'bool',
        'resource_id' => 'int',
        'state_id' => 'int',
        'country_id' => 'int',
    ];

    public function newEloquentBuilder($query)
    {
        return new AddressQuery($query);
    }

    public function accounts()
    {
        return $this->belongsToMany(
            Account::class,
            AccountAddress::class,
            'address_id',
            'account_id'
        );
    }

    public function stateProvince(): BelongsTo
    {
        return $this->belongsTo(
            StateProvince::class,
            'state_id',
        );
    }

    public function stateProvinceCached(): StateProvince
    {
        return $this->stateProvince ??= LoadStateByIdFromCache::now($this->state_id);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function countryCached(): Country
    {
        return $this->country ??= LoadCountryByIdFromCache::now($this->country_id);
    }

    public function orderTransactions()
    {
        return $this->hasMany(OrderTransaction::class, 'billing_address_id');
    }

    public function orderBillTos()
    {
        return $this->hasMany(Order::class, 'billing_address_id');
    }

    public function orderShipTos()
    {
        return $this->hasMany(Order::class, 'shipping_address_id');
    }

    public function registryShipTos()
    {
        return $this->hasMany(GiftRegistry::class, 'shipto_id');
    }

    public function accountBillingDefaults()
    {
        return $this->hasMany(Account::class, 'default_billing_id');
    }

    public function accountShippingDefaults()
    {
        return $this->hasMany(Account::class, 'default_shipping_id');
    }
    private function stateName()
    {
        return $this->stateProvince?$this->stateProvince->abbreviation:'';
    }

    public function fullPlainText(): string
    {
        $text = "";

        if ($this->company != "") {
            $text .= "{$this->company}\r\n";
        }
        $stateName = $this->stateName();
        return $text .
            "{$this->first_name} {$this->last_name}\r\n" .
            "{$this->streetPlainText()}\r\n" .
            "{$this->city}, {$stateName} {$this->postal_code}\r\n" .
            "{$this->country->abbreviation}";
    }

    public function fullHtml(): string
    {
        $html = "";

        if ($this->company != "") {
            $html .= "{$this->company}<br>";
        }
        $stateName = $this->stateName();

        return $html . <<<HTML
{$this->first_name} {$this->last_name}<br>
{$this->streetHtml()}<br>
{$this->city}, {$stateName} {$this->postal_code}<br>
{$this->country->abbreviation}
HTML;
    }

    public function streetPlainText(): string
    {
        if ($this->address_2 != "") {
            return "{$this->address_1}\r\n {$this->address_2}";
        }

        return $this->address_1;
    }

    public function streetHtml(): string
    {
        if ($this->address_2 != "") {
            return "{$this->address_1}<br> {$this->address_2}";
        }

        return $this->address_1;
    }
}
