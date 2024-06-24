<?php

namespace App\Api\Admin\Referrals\Requests;

use App\Api\Addresses\Requests\AddressRequest;
use Domain\Affiliates\Models\ReferralStatus;
use Domain\Orders\Models\Order\Order;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ReferralSearchRequest extends AddressRequest
{
    use HasFactory;

    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'status_id' => ['numeric', 'exists:' . ReferralStatus::Table() . ',id', 'nullable'],
            'order_id' => ['numeric', 'exists:' . Order::Table() . ',id', 'nullable'],
            'keyword' => ['string', 'nullable'],
            'name' => ['string', 'nullable'],
        ];
    }
}
