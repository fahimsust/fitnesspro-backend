<?php

namespace App\Api\Admin\ProductOptions\Requests;

use App\Api\Admin\ProductOptions\Rules\IsValidDateDuration;
use Domain\Products\Models\Product\Option\ProductOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CreateDateOptionValuesRequest extends FormRequest
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
            'days_skip_between' => ['numeric', 'required'],
            'start_date' => ['date', 'required'],
            'end_date' => ['date', 'after:start_date', 'required'],
            'days_duration' => [
                'numeric',
                'required',
                'gt:0',
                new IsValidDateDuration
            ],
        ];
    }
}
