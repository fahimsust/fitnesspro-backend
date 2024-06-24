<?php

namespace App\Api\Admin\Affiliates\Requests;

use App\Api\Addresses\Requests\AddressRequest;
use Domain\Addresses\Models\Address;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AffiliateAddressRequest extends AddressRequest
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
            'address_id' => ['numeric', 'exists:' . Address::Table() . ',id', 'required'],
        ];
    }
}
