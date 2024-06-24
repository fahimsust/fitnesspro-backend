<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Distributors\Models\Distributor;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class BulkProductDistributorStockQuantityRequest extends BulkProductRequest
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
            'distributor_id' => [
                'int',
                'exists:' . Distributor::Table() . ',id',
                'required'
            ],
            'stock_qty'=>[
                'numeric',
                'required'
            ]
        ]+parent::rules();
    }
}
