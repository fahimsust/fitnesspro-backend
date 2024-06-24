<?php

namespace App\Api\Site\Reviews\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;

class CreateReviewRequest extends FormRequest
{
    use HasFactory;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string','max:85', 'required'],
            'rating' => ['int', 'required',Rule::in(['1','2','3','4','5'])],
            'comment' => ['string', 'required'],
        ];
    }
}
