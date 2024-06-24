<?php

namespace Domain\Accounts\Models\Registration;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;

//todo remove
class RegistrationDiscount extends Model
{
    use HasFactory, HasModelUtilities;

    protected $table = 'registration_discounts';

    public function usesTimestamps()
    {
        return true;
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function advantage(): BelongsTo
    {
        return $this->belongsTo(DiscountAdvantage::class, 'advantage_id');
    }
}
