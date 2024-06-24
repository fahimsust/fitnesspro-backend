<?php

namespace Domain\Orders\Actions\Order\Package\Item;

class ReturnQtyToStock
{
    /*
     *
        function returnStockQty($qty=false){
            if(!$qty) $qty = $this->qty;
            if(ProductDistributor::ReturnDistributorInventory($this->actual_product_id, $this->distributor_id, $qty)){
                if($this->registry_item_id > 0){
                    GiftRegistry::updateItemPurchasedQty($this->registry_item_id, $qty, "-");
                }
                return true;
            }else $this->c_err(_t("Failed to return stock to inventory"));
            return false;
        }
     */
}
