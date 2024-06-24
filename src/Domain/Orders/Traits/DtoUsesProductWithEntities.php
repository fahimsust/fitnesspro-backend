<?php

namespace Domain\Orders\Traits;

use Domain\Discounts\Enums\OnSaleStatuses;
use Domain\Distributors\Models\Distributor;
use Domain\Future\GiftRegistry\RegistryItem;
use Domain\Orders\Dtos\AccessoryData;
use Domain\Orders\Dtos\AccessoryFieldData;
use Domain\Orders\Dtos\CustomFormFieldValueData;
use Domain\Orders\Dtos\OptionCustomValuesData;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Illuminate\Support\Collection;

trait DtoUsesProductWithEntities
{
    public ?string $label = null;

    public ?Product $parentProduct = null;

    public ?RegistryItem $registryItem = null;

    public ?int $accessoryFieldId = null;

    public ?ProductPricing $pricing = null;
    public ?ProductAvailability $availability = null;
    public ?ProductDistributor $productDistributor = null;
    public int $availableStockQty = 0;

    public ?Distributor $distributor = null;

    public Collection $optionValues;

    public Collection $customFieldValues;
    public Collection $accessoryFields;

    public Collection $accessories;

    public Collection $discountAdvantages;
    public ?CartItem $parentCartItem = null;
    public ?CartItem $cartItem = null;

    public function __construct(
        public Site    $site,
        public Product $product,
        public int     $orderQty = 1,
    )
    {
        $this->optionValues = collect();
        $this->customFieldValues = collect();
        $this->accessoryFields = collect();
        $this->accessories = collect();
        $this->discountAdvantages = collect();
    }

    public function parentCartItem(?CartItem $parentItem): static
    {
        $this->parentCartItem = $parentItem;

        return $this;
    }

    public function cartItem(CartItem $item): static
    {
        $this->cartItem = $item;

        return $this;
    }

    public function discountAdvantages(Collection $discounts): static
    {
        $this->discountAdvantages = $discounts;

        return $this;
    }

    public function availableStockQty(int $stockQty): static
    {
        $this->availableStockQty = $stockQty;

        return $this;
    }

    public function pricing(ProductPricing $productPricing): static
    {
        $this->pricing = $productPricing;

        return $this;
    }

    public function availability(ProductAvailability $availability): static
    {
        $this->availability = $availability;

        return $this;
    }

    public function accessoryFields(array $accessoryFields): static
    {
        $this->accessoryFields = collect($accessoryFields)->map(
            fn(array $field) => AccessoryFieldData::from([
                'fieldId' => $field['field_id'],
                'productId' => $field['product_id'],
                'qty' => $field['qty'],
                'options' => $field['options'],
            ])
        );

        return $this;
    }

    public function optionValues(array $options): static
    {
        $this->optionValues = collect($options)->map(
            fn(array $option) => OptionCustomValuesData::from([
                'optionValueId' => $option['option_value_id'],
                'customValue' => $option['custom_value'],
            ])
        );

        return $this;
    }

    public function customFields(array $customFields): static
    {
        $this->customFieldValues = collect($customFields)->map(
            fn(array $option) => CustomFormFieldValueData::from([
                'formId' => $option['form_id'],
                'sectionId' => $option['section_id'],
                'fieldId' => $option['field_id'],
                'value' => $option['value'],
            ])
        );

        return $this;
    }

    public function accessories(array $accessories): static
    {
        $this->accessories = collect($accessories)->map(
            fn(array $accessory) => AccessoryData::from([
                'productId' => $accessory['accessory_id'],
                'qty' => $accessory['qty'],
                'options' => $accessory['options'],
            ])
        );

        return $this;
    }

    public function childOf(int $childOfId)
    {
        if (!isset($this->distributor)) {
            $this->parentProduct = Product::find($childOfId);
        }
    }

    public function parentProduct(?Product $parentProduct): static
    {
        $this->parentProduct = $parentProduct;

        return $this;
    }

    public function distributor(?Distributor $distributor): static
    {
        $this->distributor = $distributor;

        return $this;
    }

    public function productDistributor(?ProductDistributor $productDistributor): static
    {
        $this->productDistributor = $productDistributor;

        return $this;
    }

    public function registryItem(?RegistryItem $registryItem): static
    {
        $this->registryItem = $registryItem;

        return $this;
    }

    public function accessoryFieldId(?int $fieldId): static
    {
        $this->accessoryFieldId = $fieldId;

        return $this;
    }

    public function accessoryLinkedActions(?CartItem $cartItem): static
    {
        $this->accessoryLinkedActions = $cartItem;

        return $this;
    }

    public function label(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getQty(): int
    {
        return $this->orderQty <= 0
            ? 1
            : $this->orderQty;
    }
}
