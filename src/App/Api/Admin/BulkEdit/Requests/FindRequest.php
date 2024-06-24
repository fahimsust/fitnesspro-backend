<?php

namespace App\Api\Admin\BulkEdit\Requests;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;
use Illuminate\Validation\Rules\Enum;

class FindRequest extends FormRequest
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
            'search_option' => ['string',new Enum(SearchOptions::class),'required'],
        ];
    }
}
