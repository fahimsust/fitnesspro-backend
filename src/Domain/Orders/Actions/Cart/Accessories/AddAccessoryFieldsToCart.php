<?php

namespace Domain\Orders\Actions\Cart\Accessories;

use Domain\Orders\Actions\Cart\Item\AddItemToCartFromDto;
use Domain\Orders\Actions\Cart\Item\LoadProductWithEntitiesForCartItem;
use Domain\Orders\Dtos\AccessoryFieldData;
use Domain\Orders\Dtos\CartItemAccessoryFieldDtos;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\Cart;
use Domain\Products\Models\Product\AccessoryField\AccessoryFieldProduct;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Traits\HasExceptionCollection;

class AddAccessoryFieldsToCart implements CanReceiveExceptionCollection
{
    use AsObject,
        HasExceptionCollection;

    public Collection $addedCartItems;

    public function __construct(
        public Cart        $cart,
        public CartItemDto $dto,
    ) {
        $this->addedCartItems = collect();
    }

    public function handle(): static
    {
        if (! $this->dto->accessoryFields?->count()) {
            return $this;
        }

        $this->buildQuery()
            ->get()
            ->map(
                fn (AccessoryFieldProduct $fieldProduct) => $this->buildCartItemDtoForField($fieldProduct)
            )
            ->each(
                fn (CartItemAccessoryFieldDtos $dtos) => $this->addToCart($dtos)
            );

        return $this;
    }

    private function buildQuery()
    {
        $query = AccessoryFieldProduct::select(
            AccessoryFieldProduct::Table() . '*',
            'field.id as field_id',
            'field.label as field_label',
            'field.required',
            'product.title',
            'product.product_no',
        )
            ->joinRelationship(
                'product',
                fn ($join) => $join->as('product')
            )
            ->joinRelation(
                'field',
                fn ($join) => $join->as('field')
            );

        $this->dto->accessoryFields->each(
            fn (AccessoryFieldData $dto) => $query->orWhere(
                fn ($query) => $query
                    ->where(
                        AccessoryFieldProduct::Table() . '.accessories_fields_id',
                        $dto->fieldId
                    )
                    ->where(
                        AccessoryFieldProduct::Table() . '.product_id',
                        $dto->productId
                    )
            )
        );

        return $query;
    }

    private function buildCartItemDtoForField(AccessoryFieldProduct $fieldProduct)
    {
        $dto = $this->dto->accessoryFields->firstWhere(
            fn (AccessoryFieldData $data) => $data->productId === $fieldProduct->product_id
                && $data->fieldId === $fieldProduct->field_id
        );

        return new CartItemAccessoryFieldDtos(
            LoadProductWithEntitiesForCartItem::run(
                $fieldProduct->product_id,
                $this->cart->site
            )
                ->toCartItemDto(
                    $dto->qty,
                    $dto->options
                )
                ->accessoryFieldId($fieldProduct->field_id),
            $dto
        );
    }

    private function addToCart(CartItemAccessoryFieldDtos $dtos)
    {
        $this->addedCartItems->push(
            AddItemToCartFromDto::run(
                $this->cart,
                $dtos->cartItemData
            )
                ->transferExceptionsTo($this)
                ->cartItem
        );

        //todo adjust price from field price adjustment
    }

    /*    function _addAccessoriesFields($cart, $package)
    {
        $result = true;
        if (is_array($_POST['accessories_field'])) {
            $q = new BuildSelect("SELECT a.*, f.id as field_id, f.label as field_label, f.required, p.title, p.product_no FROM
                    accessories_fields_products a
                    JOIN products p ON p.id=a.product_id
                    JOIN accessories_fields f ON f.id=a.accessories_fields_id");
            $qg = new BuildWhereGroup("", "OR");
            foreach ($_POST['accessories_field'] as $accfld) {
                list($field_id, $product_id) = explode("-", $accfld);

                $qg2 = new BuildWhereGroup("", "AND");
                $qg2->addWhereToGroup("a.accessories_fields_id", $field_id);
                $qg2->addWhereToGroup("a.product_id", $product_id);
                $qg->addCustomWhereToGroup($qg2->getGroupQuery());
            }
            $q->addCustomWhere($qg->getGroupQuery());
            $fields = new Query($q, "fields to add");
            if ($fields->getTotal() > 0) {
                if (is_object($cart)) {//add to cart
                    $last_id = $cart->last_id;
                    $last_qty = $cart->last_qty;
                    $parent_cart_id = $this->get('id');
                    $parent_product = $_POST['product_id'];
                    if (DONT_USE_PRODUCT_QTY_ON_ACCESSORYFIELD_ADDTOCART === true) $qty = 1;
                    else $qty = $last_qty;
                } else {//add to order
                    $result = "";
                }

                foreach ($fields->results as $fld) {
                    $required = $fld->required;
                    if (!$required && SEPARATE_QTY_FOR_NONREQUIRED_ACCESSORYFIELD === true) {
                        $sep_qty = $_POST['af_product_qty_' . $fld->field_id . '_' . $fld->product_id];
                        if ($sep_qty > 0) $qty = $sep_qty;
                    }
                    $options = NULL;
                    if (is_array($_POST['product_option_' . $fld->field_id . '_' . $fld->product_id])) {
                        $options = $_POST['product_option_' . $fld->field_id . '_' . $fld->product_id];
                    }
                    if (is_object($cart)) {//add to cart
                        if ($newestItem = $cart->add($fld->product_id, $qty, $options, $parent_cart_id, $parent_product, $required, $this->get('registry_item_id'), $fld->field_id)) {
                            $newestItem->label = $fld->field_label;
                            if ($fld->price_adjust_amount != 0) $newestItem->adjustPrice($fld->price_adjust_amount, $fld->price_adjust_type);
                            //$this->c_saveMsg($newestItem->title." has been added to your cart");
                        } else {
                            $result = false;
                        }
                    } else {//add to order
                        $newProd = new CartItem();
                        if ($newProd->initItem(rand(0, 9999), $fld->product_id, 1, $options, $this->orders_product_id, $this->orders_product_id, $required, $this->get('registry_item_id'), $fld->field_id)) {
                            if ($fld->price_adjust_amount != 0) $newProd->adjustPrice($fld->price_adjust_amount, $fld->price_adjust_type);
                            $newProd->label = $fld->field_label;
                            if ($newProd->addItemToOrder($package->get('order_id'), $package->get('id'))) {
                                $result .= "; " . $newProd->title . "/Id " . $newProd->get('product_id');
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }*/
}
