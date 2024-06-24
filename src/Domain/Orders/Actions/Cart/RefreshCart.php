<?php

namespace Domain\Orders\Actions\Cart;

class RefreshCart
{
//    function recheckCartContents(){
//        if(is_array($this->items)) {
//            $this->checkOrderingRules();
//
//            //reset pricing
//            foreach ($this->items as $i) {
//                $oldprice = $i->price;
//                $i->resetPricing();
//                if($oldprice != $i->price){
//                    $msg = sprintf(_t("%1s price has %2s from %3s to %4s"), $i->title, ($i->price < $oldprice) ? "decreased":"increased", Product::formatPrice($oldprice), Product::formatPrice($i->price));
//                    $this->c_msg($msg);
//                }
//            }
//        }
//        $this->updateOrder();
//    }
}
