<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class BulkProductOutOfStockRequest extends BulkProductRequest
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
            'default_outofstockstatus_id' => [
                'int',
                'exists:' . ProductAvailability::Table() . ',id',
                'nullable',
            ],
        ]+parent::rules();
    }
}
