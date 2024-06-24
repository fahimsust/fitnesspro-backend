<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;

class ArchiveProductRequest extends FormRequest
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
            'product_id' => [
                'int',
                Rule::exists(Product::Table(), 'id')->where(function ($query) {
                    return $query->whereNotNull('deleted_at');
                }),
                'required',
            ],
        ];
    }
}
