<?php

namespace Domain\Orders\Actions\Cart;

class CheckCartItemsAvailability
{
//    function checkAvailability($update = false){
//        $this->nolonger_available = array();
//        $this->nolonger_quantity = array();
//        $result = true;
//        if($this->hasItems()) {//save items, if any exist
//            foreach ($this->items as $k=>$i) {
//                $result = $i->checkAvailability($update);
//                if($result < 1){
//                    if($result < 0){
//                        $this->nolonger_available[] = $i;
//                        if($update && $result == -1) $this->deleteItem($k, $i);//update and availability doesn't allow to order
//                    }else{
//                        $this->nolonger_quantity[] = $i;
//                        $this->updateLinkedAccessoriesQty($i->get("id"), $i->get("qty"));
//                    }
//                    $result = false;
//                }
//            }
//        }
//        return $result;
//    }
}
