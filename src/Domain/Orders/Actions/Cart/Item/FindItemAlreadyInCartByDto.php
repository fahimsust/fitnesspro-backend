<?php

namespace Domain\Orders\Actions\Cart\Item;

use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemCustomField;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Support\Contracts\AbstractAction;

class FindItemAlreadyInCartByDto extends AbstractAction
{
    public function __construct(
        public Cart           $cart,
        protected CartItemDto $dto
    )
    {
    }

    public function execute(): ?CartItem
    {
        return $this->cart->items
            ->firstWhere(
                fn(CartItem $item) => $this->matchItemToDto($item)
            );
    }

    private function matchItemToDto(CartItem $item): bool
    {
        if ($item->product_id !== $this->dto->product->id
            || $item->registry_item_id !== $this->dto->registryItem?->id) {
            return false;
        }

        if (!$this->matchDtoOptionsToItemOptions($item)) {
            return false;
        }

        if (!$this->matchCustomValuesToItem($item)) {
            return false;
        }

        return true;
    }

    private function matchDtoOptionsToItemOptions(CartItem $item): bool
    {
        $count = $this->dto->optionValues
            ? count($this->dto->optionValues)
            : 0;

        if ($count !== $item->loadMissingReturn('optionValues')->count()) {
            return false;
        }

        if ($count === 0) {
            return true;
        }

        return !count(
            array_diff(
                $item->optionValues
                    ->map(
                        fn(CartItemOption $itemOption) => [
                            'option_value_id' => $itemOption->option_value_id,
                            'custom_value' => $itemOption->customValue->custom_value,
                        ]
                    )
                    ->toArray(),
                $this->dto->optionValues
            )
        );
    }

    private function matchCustomValuesToItem(CartItem $item): bool
    {
        $count = $this->dto->customFieldValues
            ? count($this->dto->customFieldValues)
            : 0;

        if ($count !== $item->loadMissingReturn('customFields')->count()) {
            return false;
        }

        if ($count === 0) {
            return true;
        }

        return !count(
            array_diff(
                $item->customFields
                    ->map(
                        fn(CartItemCustomField $itemCustomField) => $itemCustomField->only([
                            'form_id', 'section_id', 'field_id', 'value',
                        ])
                    )
                    ->toArray(),
                $this->dto->customFieldValues
            )
        );
    }
}
/*
 *
                    unset($this->item_adjusted);
                    $qty = $product_qty;
                    $already_id = 0;
                    $qty_left = $new_item->max_qty;
                    $matches_exceptdistributor = 0;

                    foreach($this->items as $unique_id=>$item){
                        if($item->free_from_discount_advantage == 0){
                            if($new_item->actual_product_id == $item->actual_product_id && $new_item->registry_item_id == $item->registry_item_id && $new_item->accessory_link_actions== $item->accessory_link_actions){
                                $matches = true;

                                if(is_array($item->get('options')) && is_array($new_item->get('options'))){//if has options, compare if custom values match
                                    $custom_vals = array();
                                    foreach($item->get('options') as $opt_key => $opts){
                                        for($z=0; $z < count($opts['value_display']); $z++){
                                            if($opts['value_custom_type'][$z] >= 0){
                                                $custom_vals[$opts['value_id'][$z]] = $opts['value_custom_value'][$z];
                                            }
                                        }
                                    }
                                    if(count($custom_vals) > 0){//has custom values, check if they are the same
                                        $new_custom_vals = array();
                                        foreach($new_item->get('options') as $opt_key => $opts){
                                            for($z=0; $z < count($opts['value_display']); $z++){
                                                if($opts['value_custom_type'][$z] >= 0){
                                                    $new_custom_vals[$opts['value_id'][$z]] = $opts['value_custom_value'][$z];
                                                }
                                            }
                                            if(count($new_custom_vals) > 0){
                                                if(count(array_diff($custom_vals, $new_custom_vals)) > 0){//found differences in custom vals
                                                    $matches = false;
                                                }
                                            }else $matches = false;//existing item has custom values, new doesn't
                                        }
                                    }
                                    if($matches){//matches to this point
                                        if(is_array($new_item->custom_fields)){//check if custom field values match
                                            foreach($new_item->custom_fields as $form_id=>$section){
                                                foreach($section as $section_id=>$field){
                                                     foreach($field as $field_id=>$value){
                                                         if(!isset($item->custom_fields[$form_id][$section_id][$field_id]) || $item->custom_fields[$form_id][$section_id][$field_id] != $value){
                                                             $matches = false;
                                                             break 3;
                                                         }
                                                     }
                                                }
                                            }
                                        }

                                        if($required != $item->get('required')){
                                            $matches = false;
                                        }

                                        if((is_array($required_accessories) && !is_array($item->required_accessories))
                                            || (!is_array($required_accessories) && is_array($item->required_accessories))
                                            || is_array($required_accessories) && is_array($item->required_accessories) && count(array_diff($required_accessories, $item->required_accessories)) > 0){
                                            $matches = false;
                                            $qty_left -= $item->qty;
                                        }

                                        if($matches){
                                            if($new_item->distributor_id == $item->distributor_id){
                                                $already_id = $item->get('id');
                                                $new_item->setId($already_id);
                                                $qty_left -= $item->qty;
                                            }else{
                                                $matches_exceptdistributor = $item->qty;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
 */
