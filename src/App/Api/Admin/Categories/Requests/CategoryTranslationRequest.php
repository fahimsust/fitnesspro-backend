<?php

namespace App\Api\Admin\Categories\Requests;

use Domain\Products\Models\Category\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CategoryTranslationRequest extends FormRequest
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

    public function urlRule()
    {
        $validation = ['string','regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'max:255', 'required'];
        if (isset($this->categoryTranslation->id)) {
            $validation[] = 'unique:categories,url_name,'.$this->categoryTranslation->id;
        } else {
            $validation[] = 'unique:categories';
        }
        return $validation;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['string','max:255', 'required'],
            'subtitle' => ['string', 'max:155', 'nullable'],
            'url_name' => $this->urlRule(),
            'description' => ['string','nullable'],
        ];
    }
}
