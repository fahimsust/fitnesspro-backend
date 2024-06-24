<?php

namespace App\Api\Admin\Orders\Requests;

use Domain\Distributors\Models\Distributor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CreateShipmentRequest extends FormRequest
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
            'is_downloads' => ['boolean', 'required'],
            'distributor_id' => ['int', 'exists:' . Distributor::Table() . ',id', 'required']
        ];
    }
}