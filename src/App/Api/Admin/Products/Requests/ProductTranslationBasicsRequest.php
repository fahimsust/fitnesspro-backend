<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Products\Models\Product\ProductTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductTranslationBasicsRequest extends FormRequest
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
        if($this->product != null)
        {
            $productTranslation = ProductTranslation::where('product_id',$this->product->id)->where('language_id',$this->route('translation'))->first();
            if($productTranslation)
            {
                $validation[] = 'unique:product_translations,url_name,'.$productTranslation->id;
            }
            else
            {
                $validation[] = 'unique:product_translations,url_name';
            }
        }
        else
        {
            $validation[] = 'unique:product_translations,url_name';
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
            'title' => ['string', 'required'],
            'subtitle' => ['string', 'max:255', 'nullable'],
            'url_name' => $this->urlRule(),
        ];
    }
}
