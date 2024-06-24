<?php

namespace App\Api\Admin\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductCustomsInfoRequest extends FormRequest
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
            'customs_description' => ['string','max:255', 'nullable'],
            'tariff_number' => ['string','max:55', 'nullable'],
            'country_origin' => ['string','max:20', 'nullable'],
        ];
    }
}
