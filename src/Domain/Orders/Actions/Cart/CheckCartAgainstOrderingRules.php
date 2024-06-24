<?php

namespace Domain\Orders\Actions\Cart;

class CheckCartAgainstOrderingRules
{
//
//    function checkOrderingRules($get_errors=false){
//        $result = true;
//        if(is_array($this->items)) {
//            foreach ($this->items as $k => $i) {
//                if (!$i->checkOrderingRule($this->customer)) {
//                    $result = false;
//                    if($get_errors) $this->getModelErrs($i);
//
//                    if (DONT_REMOVEFROMCART_ONLOGOUT !== true){
//                        $this->deleteFromCart($i->get('id'));
//                        if (DONT_SHOW_REMOVEDFROMCART_ONLOGOUT !== true) $this->c_err(sprintf(_t("Removing %1s from cart because you don't meet the requirements for ordering it."), $i->title));
//                    }
//                }
//            }
//        }
//        return $result;
//    }
}
