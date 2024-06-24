<?php

namespace App\Api\Accounts\Requests\Registration;

use App\Api\Addresses\Requests\AddressRequest;
use Worksome\RequestFactories\Concerns\HasFactory;

class CreateAccountAddressRequest extends AddressRequest
{
    use HasFactory;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return parent::rules();
    }
}
