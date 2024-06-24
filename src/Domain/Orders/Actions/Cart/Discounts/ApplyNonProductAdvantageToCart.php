<?php

namespace Domain\Orders\Actions\Cart\Discounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Lorisleiva\Actions\Concerns\AsObject;

class ApplyNonProductAdvantageToCart
{
    use AsObject;

    public CartDiscount $cartDiscount;
    public DiscountAdvantage $advantage;

    public function handle(
        CartDiscount $cartDiscount,
        DiscountAdvantage $advantage
    ): CartDiscountAdvantage {
        return $cartDiscount->advantages()->create([
            'advantage_id' => $advantage->id,
            'amount' => $advantage->amount,
        ]);
    }
}
/*
 *
    function loadAdvantages(){
        $auto_add = array(9, 13, 14);
        foreach($this->advantages->results as $r){
            if($r->type == 7){
                    $amount = "%".$r->amount;
                }else{
                    $amount = $r->amount;
                }
                $this->cart->addOrderDiscount(array(
                    "discount_id" => $r->id,
                    "display" => $r->display,
                    "amount" => $amount,
                    "advantage_id" => $r->aid
                ));
        }
    }
 *
 */
