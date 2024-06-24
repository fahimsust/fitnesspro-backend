<?php

namespace App\Api\Admin\Sites\Requests;

use Domain\Sites\Models\Layout\Layout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;
use Illuminate\Validation\Rule;

class UpdateSectionLayoutRequest extends FormRequest
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
            'layout_id' => ['numeric', 'exists:' . Layout::Table() . ',id', 'nullable'],
            'field_name' => ['string','required', Rule::in([
                'search_layout_id',
                'default_layout_id',
                'default_category_layout_id',
                'home_layout_id',
                'default_product_layout_id',
                'page_layout_id',
                'affiliate_layout_id'
            ]),],
        ];
    }
}
