<?php

namespace Domain\Orders\Actions\Order\Package\Item;

class AddCartItemToOrderPackage
{
    /*
     *
        function addItemToOrder($order_id, $package_id, $qty=false){
            //$this->debug = true;
            if(!$qty) $qty = $this->qty;
            $this->_debug("addItemToOrder()");
            $i = new BuildInsert("INSERT INTO orders_products");
            $i->addInsert("cart_id", $this->id);
            $i->addInsert("order_id", $order_id);
            $i->addInsert("package_id", $package_id);
            $i->addInsert("product_id", $this->product_id);
            $i->addInsert("actual_product_id", $this->actual_product_id);
            $i->addInsert("product_label", $this->label);
            $i->addInsert("product_qty", $qty);
            if($this->parent_product > 0) $i->addInsert("parent_product_id", $this->parent_cart_id);
            if($this->base_price > $this->price){//if volume discount is applied
                $i->addInsert("product_price", $this->base_price);
                $i->addInsert("product_saleprice", $this->price);
                $i->addInsert("product_onsale", 1);
            }else{
                $i->addInsert("product_price", $this->price_reg);
                if($this->price_sale > 0){
                    $i->addInsert("product_saleprice", $this->price_sale);
                    $i->addInsert("product_onsale", 1);
                }
            }
            $i->addInsert("free_from_discount_advantage", $this->free_from_discount_advantage);
            if($this->registry_item_id > 0) $i->addInsert("registry_item_id", $this->registry_item_id);
            $this->mlog($i->getQuery());$this->_debug($i->getQuery());
            if(db()->query($i->getQuery())){
                $this->orders_product_id = db()->insertid();
                $this->_debug("orders_product_id = ".$this->orders_products_id);
                if($this->registry_item_id > 0){
                    $this->_debug("addItemPurchased for registry_item_id ".$this->registry_item_id);
                    GiftRegistry::addItemPurchased($this->registry_item_id, $this->qty, $order_id, $this->orders_product_id, $this->customer);
                }

                //Add Options
                $this->_debug("count options ".count($this->options));
                if(count($this->options) > 0){
                    foreach($this->options as $opt_key => $opts){
                        $this->_debug("option ".$opt_key." => ".var_export($opts, true));
                        for($x=0; $x < count($opts['value_id']); $x++){
                            $i = new BuildInsert("INSERT INTO orders_products_options");
                            $i->addInsert("orders_products_id", $this->orders_product_id);
                            $i->addInsert("value_id", $opts['value_id'][$x]);
                            $i->addInsert("price", $opts['value_price'][$x]);
                            if($opts['value_custom_type'] >= 0) $i->addInsert("custom_value", $opts['value_custom_value'][$x]);
                            $this->mlog($i->getQuery());$this->_debug($i->getQuery());
                            if(!db()->query($i->getQuery())){
                                $this->c_err(_t("Failed to enter product option"));
                                $this->elog(db()->error());$this->_debug(db()->error());
                                System::log("Failed to enter product option: ".$i->getQuery()."->".db()->error());
                                return false;
                            }
                        }
                    }
                }

                $this->_debug("custom_fields ".var_export($this->custom_fields, true));
                if($this->custom_fields){
                    foreach($this->custom_fields as $form_id=>$section){
                        foreach($section as $section_id=>$fields){
                            foreach($fields as $field_id=>$field){
                                $i = new BuildInsert("INSERT INTO orders_products_customfields");
                                $i->addInsert("orders_products_id", $this->orders_product_id);
                                $i->addInsert("form_id", $form_id);
                                $i->addInsert("section_id", $section_id);
                                $i->addInsert("field_id", $field_id);
                                $i->addInsert("value", $field['value']);
                                $this->mlog($i->getQuery());$this->_debug($i->getQuery());
                                if(!$i->exec()){
                                    $this->elog(db()->error());$this->_debug(db()->error());
                                    $this->c_err(_t("Failed to enter product custom field value"));
                                    System::log("Failed to enter product custom field value: ".$i->getQuery()."->".db()->error());
                                    return false;
                                }
                            }
                        }
                    }
                }

                //Update Stock Amount
                $this->removeStockQty($qty);

                return true;
            }
            return false;
        }
     */
}
