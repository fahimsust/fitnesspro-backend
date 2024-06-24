<?php

namespace App\Api\Admin\Discounts\Requests;

use App\Api\Addresses\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class DiscountRequest extends AddressRequest
{
    use HasFactory;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string', 'max:85', 'required'],
            'display' => ['string', 'max:85', 'required'],
            'start_date' => ['nullable', 'date'],
            'exp_date' => ['nullable', 'date'],
            'limit_uses' => ['integer', 'nullable'],
            'limit_per_order' => ['integer', 'nullable'],
            'limit_per_customer' => ['integer', 'nullable'],
        ];
    }
    public function withValidator($validator)
    {
        $validator->sometimes('exp_date', 'after_or_equal:start_date', function ($input) {
            return !is_null($input->start_date) && !is_null($input->exp_date);
        });
    }
}
