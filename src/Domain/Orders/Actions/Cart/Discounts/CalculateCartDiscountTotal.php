<?php

namespace Domain\Orders\Actions\Cart\Discounts;

class CalculateCartDiscountTotal
{
    /*
     * 		function getDiscountTotal(){
                $total = 0;
                //var_dump($this->order_discounts);
                foreach($this->order_discounts as $o){
                    if(strstr($o['amount'], "%")){
                        $amount = str_replace("%", "", $o['amount']);
                        $amount = $amount / 100;
                        $total += $this->getSubTotal() * $amount;
                    }else{
                        $total += $o['amount'];
                    }
                    $o['applied_amount'] = Product::priceFormat($total);
                }
                return Product::priceFormat($total);
            }
     */
}
