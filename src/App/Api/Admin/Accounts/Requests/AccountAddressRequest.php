<?php

namespace App\Api\Admin\Accounts\Requests;

use App\Api\Addresses\Requests\AddressRequest;
use App\Rules\AtLeastOneTrue;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AccountAddressRequest extends AddressRequest
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
            'is_shipping' => ['boolean', 'required', new AtLeastOneTrue('is_billing', 'Select either shipping or billing address')],
            'is_billing' => ['boolean', 'required', new AtLeastOneTrue('is_shipping', 'Select either shipping or billing address')],
            'status' => ['boolean', 'required'],
        ] + parent::rules();
    }
}
