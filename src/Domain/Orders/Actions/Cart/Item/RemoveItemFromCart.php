<?php

namespace Domain\Orders\Actions\Cart\Item;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveItemFromCart
{
    use AsObject;

    public function handle(
        CartItem $cartItem
    ): bool {
        return $cartItem->delete();
    }

    //fk cascade on delete should handle any related items
    /*
     *
            function deleteFromCart($item_id){
                $result = true;
                foreach($this->items as $k => $i){
                    if($i->get('id') == $item_id || $i->get('parent_cart_id') == $item_id){
                        if(!$this->deleteItem($k, $i)) $result = false;
                    }
                }
                return $result;
            }

    function deleteItem($key, $item){
        if(is_object($this->items[$key])){
            $this->qty -= $item->get('qty');
            if($this->qty < 0){
                $this->qty = 0;
            }
            unset($this->items[$key]);

            $this->deleteLinkedAccessories($item->get("id"));


    return true;
}else{
$this->c_err(sprintf(_t("Item (%1s) %2s could not be found"), $key, $item->get('title')));
}
return false;
}
     */
}
