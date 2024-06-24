<?php

namespace App\Api\Admin\Orders\Requests;

use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AddProductToOrderPackageRequest extends FormRequest
{
    use HasFactory;

    private Collection $productOptions;
    private Product $product;

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
        $rules = [
            'package_id' => ['required', 'exists:' . OrderPackage::Table() . ',id'],
            'child_product_id' => ['required', 'exists:' . Product::Table() . ',id'],
            'qty' => ['required', 'int', 'min:1'],
            'custom_field_values' => ['nullable', 'array'],
            'accessories' => ['nullable', 'array'],
        ];

        // Check if product_options exist for the given product_id
        if ($this->hasProductOptions()) {
            $rules['option_custom_values'] = ['nullable', 'array'];
            $rules['option_custom_values.*.option_value_id'] = ['int'];
            $rules['option_custom_values.*.custom_value'] = ['nullable','string'];
        }

        return $rules;
    }

    public function getValuesValidationRule()
    {
        //todo i'm not sure this validation is right so i'm not using it for now

        $productOption = $this->loadOptions()
            ->whereIn('id', $this->input('options.*.id'))
            ->first();

        // Check if the 'required' field is 0 for the corresponding product option

        // If 'required' is 0, values are not required, otherwise use the standard validation rule
        $standardRule = $productOption->required == false ? [] : ['required', 'array'];

        $checkboxRule = ['array'];

        return $productOption->type_id == 2 ? $checkboxRule : $standardRule;
    }

    public function hasProductOptions(): bool
    {
        return $this->loadOptions()->isNotEmpty();
    }

    protected function loadOptions(): Collection
    {
        return $this->productOptions ??= $this->loadProduct()->options;
    }

    protected function loadProduct(): Product
    {
        return $this->product ??= Product::find($this->input('child_product_id'));
    }
}
