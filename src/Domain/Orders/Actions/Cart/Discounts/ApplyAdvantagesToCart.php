<?php

namespace Domain\Orders\Actions\Cart\Discounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class ApplyAdvantagesToCart
{
    use AsObject;

    public Cart $cart;
    public CartDiscount $cartDiscount;
    public Collection $advantages;

    public function handle(
        Cart $cart,
        CartDiscount $cartDiscount,
        Collection $advantages,
    ) {
        $this->cart = $cart;
        $this->cartDiscount = $cartDiscount;
        $this->advantages = $advantages;

        //apply cart advantages
        $this->advantages->each(
            fn (DiscountAdvantage $advantage) => $this->applyAdvantage($advantage)
        );
    }

    protected function applyAdvantage(DiscountAdvantage $advantage)
    {
        return match (true) {
            $advantage->type()->isProductAdvantage() => ApplyProductAdvantageToCart::run(
                $this->cart,
                $this->cartDiscount,
                $advantage,
            ),

            $advantage->type()->isShippingAdvantage(),
            $advantage->type()->isOrderAdvantage() => ApplyNonProductAdvantageToCart::run(
                $this->cartDiscount,
                $advantage
            ),
        };
    }
}
/*
 *
    function loadAdvantages(){
        $auto_add = array(9, 13, 14);
        foreach($this->advantages->results as $r){
            if(in_array($r->type, array_merge($this->productSpecificAdv(), $this->productTypeSpecificAdv()))){//product specific advantage
                switch($r->type){
                    case '9'://free product, auto add to cart
                    case '13'://percentage off product, auto add to cart
                    case '14'://amount off product, auto add to cart
                        if($r->type == 13) $amount = "%".$r->amount;
                        if($r->type == 14) $amount = $r->amount;
                        else $amount = "FREE";
                        foreach($r->products as $p){//loop through this advantages products
                            $found = -1;
                            foreach($this->cart->items as $k=>$i){//find if free item exists in cart
                                if(in_array($p->id, array($i->get('product_id'), $i->get('actual_product_id')))){
                                    if($i->free_from_discount_advantage == $r->aid){
                                        $found = $k; break 1;
                                    }
                                }
                            }
                            $new_discount = new CartProductDiscount($r->get('id'), $r->get('display'), $amount, $p->applyto_qty, $r->get('aid'));
                            $this->cart->addProductDiscount($new_discount);

                            if($found == -1){//free item does not exist in cart yet
                                if($new_item = $this->cart->add_freeitem($r->aid, $p->id, $p->applyto_qty)){
                                    $new_item->applyDiscount($new_discount, $r->aid);
                                }
                            }else{//free product has already been added, update qty, use key to grab it
                                $item = $this->cart->items[$found];
                                $item->updateQty($item->qty + $p->applyto_qty);
                                $this->cart->updateLinkedAccessoriesQty($i->get('id'), $i->get("qty"));
                                $item->applyDiscount($new_discount, $r->aid);
                            }
                        }
                        break;
                    case '4'://free product if it exists in cart
                    case '10'://free product type if it exists in cart
                        $amount = "FREE";
                        break;
                    case '5'://percentage off product
                    case '11'://percent off product type
                        $amount = "%".$r->amount;
                        break;
                    case '6'://amount off product
                    case '12':
                        $amount = $r->amount;
                        break;
                }

                if(!in_array($r->type, $auto_add)){//not free auto add
                    if($r->applyto_qty_type == 0){//combined
                        $available_qty = $r->applyto_qty_combined;
                        if(in_array($r->type, $this->productSpecificAdv())){//checking products
                            foreach($r->products as $p){//loop through this advantages products
                                foreach($this->cart->items as $i){
                                    if(in_array($p->id, array($i->get('product_id'), $i->get('actual_product_id'))) && $i->getTotal() > 0){//added check to only apply advantage if product amount has some value
                                        $available_qty = $this->_applyProductAdvantage($r, $i, $available_qty, $amount);
                                        if($available_qty <= 0) break 2;
                                    }
                                }
                            }
                        }else if(in_array($r->type, $this->productTypeSpecificAdv())){//checking product types
                            foreach($r->producttypes as $p){
                                foreach($this->cart->items as $i){
                                    if($i->type_id == $p->id && $i->getTotal() > 0){//added check to only apply advantage if product amount has some value
                                        $available_qty = $this->_applyProductAdvantage($r, $i, $available_qty, $amount);
                                        if($available_qty <= 0) break 2;
                                    }
                                }
                            }
                        }
                    }else if($r->applyto_qty_type == 1){//individual
                        if(in_array($r->type, $this->productSpecificAdv())){//checking products
                            foreach($r->products as $p){//loop through this advantages products
                                $available_qty = $p->applyto_qty;
                                foreach($this->cart->items as $i){
                                    if(in_array($p->id, array($i->get('product_id'), $i->get('actual_product_id'))) && $i->getTotal() > 0){//added check to only apply advantage if product amount has some value
                                        $available_qty = $this->_applyProductAdvantage($r, $i, $available_qty, $amount);
                                        if($available_qty <= 0) break;
                                    }
                                }
                            }
                        }else if(in_array($r->type, $this->productTypeSpecificAdv())){//checking product types
                            foreach($r->producttypes as $p){
                                $available_qty = $p->applyto_qty;
                                foreach($this->cart->items as $i){
                                    if($i->type_id == $p->id && $i->getTotal() > 0){//added check to only apply advantage if product amount has some value
                                        $available_qty = $this->_applyProductAdvantage($r, $i, $available_qty, $amount);
                                        if($available_qty <= 0) break ;
                                    }
                                }
                            }
                        }
                    }
                }
            }else if($r->type >= 7 && $r->type <= 8){//If order discount
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
            }else if($r->type >= 1 && $r->type <= 3){
                if($r->type == 1){
                    $amount = "FREE";
                }else if($r->type == 2){
                    $amount = "%".$r->amount;
                }else{
                    $amount = $r->amount;
                }
                $this->cart->addShippingDiscount(array(
                    "discount_id" => $r->id,
                    "display" => $r->display,
                    "amount" => $amount,
                    "shipping_id" => $r->apply_shipping_id,
                    "shipping_country" => $r->apply_shipping_country,
                    "shipping_distributor" => $r->apply_shipping_distributor,
                    "advantage_id" => $r->aid,
                ));
            }
        }
    }
    function _applyProductAdvantage($r, $i, $available_qty, $amount){
        if($i->get('qty') >= $available_qty){
            $qty = $available_qty;
            $available_qty = 0;
        }else{
            $qty = $i->get('qty');
            $available_qty -= $i->get('qty');
        }

        $new_discount = new CartProductDiscount($r->get('id'), $r->get('display'), $amount, $qty, $r->get('aid'));
        $this->cart->addProductDiscount($new_discount);
        $i->applyDiscount($new_discount, $r->aid);
        return $available_qty;
    }
 *
 */
