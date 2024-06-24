<?php

namespace Domain\Orders\Actions\Cart\Discounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Actions\Cart\Item\Discounts\ApplyAdvantageToCartItem;
use Domain\Orders\Actions\Cart\Item\Discounts\ApplyAutoAddItemAdvantageToCart;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class ApplyProductAdvantageToCart
{
    use AsObject;

    public Cart $cart;
    public CartDiscount $cartDiscount;
    public DiscountAdvantage $advantage;
    private ?int $combinedAvailableQty;

    public function handle(
        Cart $cart,
        CartDiscount $cartDiscount,
        DiscountAdvantage $advantage,
    ) {
        $this->cart = $cart;
        $this->cartDiscount = $cartDiscount;
        $this->advantage = $advantage;

        if ($this->advantage->type()->isAutoAdd()) {
            return ApplyAutoAddItemAdvantageToCart::run(
                $this->cart,
                $this->advantage,
                $this->cartDiscount,
            );
        }

        if ($this->advantage->applyQtyType()->isCombined()) {
            $this->combinedAvailableQty = $this->advantage->applyto_qty_combined;
        }

        if ($this->advantage->type()->isProductSpecific()) {
            return $this->advantage->loadMissingReturn('targetProducts')
                ->each(
                    fn (Product $product) => $this->applyAdvantageToItems(
                        $this->cart->items->filter(
                            fn (CartItem $item) => $item->totalAmount() > 0 //added check to only apply advantage if product amount has some value
                                && $item->isProduct($product)
                        ),
                        $this->qtyToUse($product->pivot->applyto_qty)
                    )
                );
        }

        if ($this->advantage->type()->isProductTypeSpecific()) {
            return $this->advantage->loadMissingReturn('targetProductTypes')
                ->each(
                    fn (ProductType $type) => $this->applyAdvantageToItems(
                        $this->cart->items->filter(
                            fn (CartItem $item) => $item->totalAmount() > 0
                                && $item->isProductType($type)
                        ),
                        $this->qtyToUse($type->pivot->applyto_qty)
                    )
                );
        }
    }

    private function qtyToUse(int $individualQty)
    {
        return $this->advantage->qtyToUse(
            $this->combinedAvailableQty,
            $individualQty
        );
    }

    private function applyAdvantageToItems(
        Collection $matchingItems,
        int $availableQty
    ): int|bool {
        if ($availableQty <= 0 && $this->advantage->applyQtyType()->isCombined()) {
            return false;
        }

        $matchingItems
            ->each(
                function (CartItem $item) use ($availableQty) {
                    $availableQty = $this->applyAdvantageToItem($item, $availableQty);

                    if ($availableQty === 0) {
                        return false;
                    }
                }
            );

        if ($this->advantage->applyQtyType()->isCombined()) {
            $this->combinedAvailableQty = $availableQty;
        }

        return $availableQty;
    }

    private function applyAdvantageToItem(CartItem $item, int $availableQty): int
    {
        $itemAdvantage = ApplyAdvantageToCartItem::run(
            $this->cartDiscount,
            $this->advantage,
            $item,
            $availableQty
        );

        return $availableQty - $itemAdvantage->qty;
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
            }
....
        }
    }
 *
 */
