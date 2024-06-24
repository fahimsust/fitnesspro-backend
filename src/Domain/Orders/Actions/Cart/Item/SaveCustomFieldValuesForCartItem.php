<?php

namespace Domain\Orders\Actions\Cart\Item;

use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Dtos\CustomFormFieldValueData;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Support\Contracts\AbstractAction;

class SaveCustomFieldValuesForCartItem extends AbstractAction
{
    public function __construct(
        protected CartItem    $item,
        protected CartItemDto $dto
    )
    {
    }

    public function execute(): ?CartItem
    {
        if (!$this->dto->customFieldValues?->count()) {
            return null;
        }

        return $this->item->setRelation(
            'customFields',
            $this->item->customFields()->createMany(
                $this->dto->customFieldValues->map(
                    fn(CustomFormFieldValueData $data) => $data->toArray()
                )
            )
        );
    }
}

/*
 *
        function saveCustomFieldsValues($custom_fields, $cart_item_id){
            if($custom_fields){
                foreach($custom_fields as $form_id=>$section){
                    foreach($section as $section_id=>$fields){
                        foreach($fields as $field_id=>$field){
                            if($field['value'] != ""){//has custom value
                                $i = new BuildInsert("INSERT INTO saved_cart_items_customfields");
                                $i->addInsert("saved_cart_item_id", $cart_item_id);
                                $i->addInsert("form_id", $form_id);
                                $i->addInsert("section_id", $section_id);
                                $i->addInsert("field_id", $field_id);
                                $i->addInsert("value", $field['value']);
                                $i->onDuplicateUpdate();
                                if(!db()->query($i->getQuery())){
                                    $this->c_err(_t("Failed to save custom fields value").": ".$i->getQuery()."->".db()->error());
                                }
                            }
                        }
                    }
                }
            }
        }
 */
