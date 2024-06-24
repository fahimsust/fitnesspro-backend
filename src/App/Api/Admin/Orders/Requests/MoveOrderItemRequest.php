<?php

namespace App\Api\Admin\Orders\Requests;

use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class MoveOrderItemRequest extends FormRequest
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
            'package_id' => ['int', 'exists:' . OrderPackage::Table() . ',id', 'required'],
        ];
    }
}
