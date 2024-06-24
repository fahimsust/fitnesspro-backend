<?php

namespace Support\Traits\BelongsTo;

use Domain\Payments\Actions\LoadPaymentMethodById;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToPaymentMethod
{
    private PaymentMethod $paymentMethodCached;

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(
            PaymentMethod::class,
            'payment_method_id'
        );
    }

    public function paymentMethodCached(): ?PaymentMethod
    {
        if (!$this->payment_method_id) {
            return null;
        }

        $this->paymentMethodCached ??= LoadPaymentMethodById::now(
            $this->payment_method_id
        );

        $this->setRelation(
            'paymentMethod',
            $this->paymentMethodCached
        );

        return $this->paymentMethodCached;
    }
}
