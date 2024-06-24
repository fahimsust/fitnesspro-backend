<?php

namespace Domain\Orders\Actions\Order\Package\Item;

class RemoveQtyFromStock
{
    /*
     *     function removeStockQty($qty=false){
            if(!$qty) $qty = $this->qty;
            $this->_debug("removeStockQty ".$this->actual_product_id." ".$this->distributor_id." ".$qty);
            if(ProductDistributor::RemoveDistributorInventory($this->actual_product_id, $this->distributor_id, $qty)){
                if($this->registry_item_id > 0){
                    GiftRegistry::updateItemPurchasedQty($this->registry_item_id, $qty);
                }
                return true;
            }else $this->c_err(_t("Failed to remove stock to inventory"));
            return false;
        }
     */
}
