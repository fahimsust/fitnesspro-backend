<?php

namespace Domain\Orders\Actions\Cart\Item\Options;

use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Lorisleiva\Actions\Concerns\AsObject;

class SaveOptionCustomValuesForCartItem
{
    use AsObject;

    public function handle(
        CartItemOption $itemOption,
        string $customValue
    ) {
        if (empty($customValue)) {
            return false;
        }

        return $itemOption->customValue()
            ->create([
                'custom_value' => $customValue,
            ]);
    }
    /*
     *         function saveOptionCustomValues($options, $cart_item_id){
                foreach($options as $o){
                    if($o['value_custom_value'][0] != ""){//has custom value
                        $i = new BuildInsert("INSERT INTO saved_cart_items_options_customvalues");
                        $i->addInsert("saved_cart_item_id", $cart_item_id);
                        $i->addInsert("option_id", $o['value_id'][0]);
                        $i->addInsert("custom_value", $o['value_custom_value'][0]);
                        $i->onDuplicateUpdate();
                        if(!db()->query($i->getQuery())){
                            $this->c_err(_t("Failed to load option custom value").": ".db()->error());
                        }
                    }
                }
            }
     */
}
