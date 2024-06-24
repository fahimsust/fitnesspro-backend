<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class DistributorsInventoryRequest extends FormRequest
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
            'outofstockstatus_id' => [
                'int',
                'exists:' . ProductAvailability::Table() . ',id',
                'nullable',
            ],
            'distributor_id' => [
                'int',
                'exists:' . Distributor::Table() . ',id',
                'nullable',
            ],
            'stock_qty' => ['numeric','nullable'],
            'cost' => ['numeric','nullable'],
        ];
    }
}
