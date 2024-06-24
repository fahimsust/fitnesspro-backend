<?php

namespace Domain\Payments\QueryBuilders;

use Domain\Payments\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PaymentAccountQuery extends Builder
{
    public function forPaymentMethod(Request $request): static
    {
        return $this->whereGatewayId(PaymentMethod::find($request->payment_method_id)->gateway_id);
    }
}
