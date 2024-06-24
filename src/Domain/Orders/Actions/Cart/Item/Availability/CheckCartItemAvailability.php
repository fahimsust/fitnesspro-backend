<?php

namespace Domain\Orders\Actions\Cart\Item\Availability;

class CheckCartItemAvailability
{
    /*
     *
        function checkAvailability($update = false){//only creates errors if update=true
            if($this->inventoried != 1) return 1;//only deal with inventoried items

            if($this->distributor_id > 0){
                $prod = Product::LoadWithDistributor($this->actual_product_id, $this->distributor_id, true, $this->customer);
            }else{
                $prod = new Product($this->actual_product_id, "", false);
                $prod->load(true);
            }

            if($this->calculated_availability_id != $prod->calculated_availability_id ||
                $this->stock_qty > $prod->stock_qty){//only check if availability or stock qty has changed

                $availability_changed = false;
                if($prod->stock_qty < 1 && $this->calculated_availability_id != $prod->calculated_availability_id)
                    $availability_changed = true;

                $this->stock_qty = $prod->stock_qty;
                $this->availability_id = $prod->availability_id;
                $this->calculated_availability_id = $prod->calculated_availability_id;
                $this->calculated_availability_name = $prod->calculated_availability_name;

                if(!$this->allowOrderAvailability()){
                    if($update) $this->c_err(sprintf(_t("Sorry, %s is no longer available."), $this->title));
                    return -1;
                }else if($availability_changed){
                    if($update) $this->c_err(sprintf(_t("Sorry, %s availability has changed."), $this->title));
                    return -2;
                }

                if($this->stock_qty < $this->qty){
                    if($update){
                        $this->updateQty($this->stock_qty, true);
                        $this->c_err(sprintf(_t("Sorry, %s is no longer available in the quantity you want.  The quantity in your cart has been updated to %u"), $this->title, $this->stock_qty));
                    }else{
                        //$this->c_err("Sorry, ".$this->title." is no longer available in the quantity you want.  There are only ".$this->stock_qty." now available");
                    }
                    return 0;
                }
            }
            return 1;
        }
     */
}
