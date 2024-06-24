<?php

namespace Domain\Accounts\Models;

use Domain\Addresses\Models\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;

class AccountAddress extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'accounts_addressbook';

    protected $casts = [
        'is_billing' => 'boolean',
        'is_shipping' => 'boolean',
    ];
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    //
    //  public function discountAdvantages()
    //  {
    //      return $this->hasMany(DiscountAdvantage::class, 'apply_shipping_id');
    //  }
    //
    //    public function savedOrderBillTos()
    //    {
    //        return $this->hasMany(CheckoutDetails::class, 'account_shipping_id');
    //    }
    //
    //    public function savedOrderShipTos()
    //    {
    //        return $this->hasMany(CheckoutDetails::class, 'account_shipping_id');
    //    }
}
