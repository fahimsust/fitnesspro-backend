<?php

namespace Domain\Orders\Actions\Cart\Item\Pricing;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateCartItemPrice
{
    use AsObject;

    public function handle(
        CartItem $item,
        ?int $priceReg = null,
        ?int $priceSale = null,
        ?bool $onSale = null
    ) {
        $item->update([
            'price_reg' => $priceReg,
            'price_sale' => $priceSale,
            'onsale' => $onSale,
        ]);
    }
/*
 * 		function setPrices($price_reg, $price_sale, $onsale){
            //if(IS_ADMIN > 0){
                $this->price_reg = $price_reg;
                if($onsale == 1){
                    $this->price_sale = $price_sale;
                    $this->price = $price_sale;
                }else{
                    $this->price = $price_reg;
                }
                $this->base_price = $this->price;
            //}
        }
 */
}
