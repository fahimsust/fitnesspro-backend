<?php

namespace App\Api\Admin\Addresses\Requests;

use App\Api\Addresses\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CreateAddressRequest extends AddressRequest
{
    use HasFactory;

    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return parent::rules();
    }
}
