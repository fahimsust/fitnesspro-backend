<?php

namespace Domain\Products\Actions\Product;

class LoadProductWithDistributor
{
    /*
     *
                function _loadWithDistributor($distributor_id, $basics_only=false){
                    $q = new BuildSelect("SELECT p.*,
        pdist.outofstockstatus_id, pdist.cost, pdist.inventory_id, pdist.stock_qty, pdist.inventory_id,
        IFNULL(da.display, IF(a.display IS NOT NULL, a.display, a.name)) as availability_name,
        SUM(cpdist.stock_qty) as child_stock_qty
        FROM products p
        JOIN products_distributors pdist ON pdist.product_id=p.id
        LEFT JOIN `products-availability` a ON a.id=pdist.outofstockstatus_id
        LEFT JOIN distributors_availabilities da ON da.availability_id=a.id AND da.distributor_id=pdist.distributor_id
        LEFT JOIN products cp ON p.parent_product=0 AND cp.parent_product=p.id
        LEFT JOIN products_distributors cpdist ON p.parent_product=0 AND cpdist.product_id=p.id AND cpdist.distributor_id=pdist.distributor_id");
                    $q->addWhere("p.id", $this->id);
                    $q->addWhere("pdist.distributor_id", $distributor_id);
                    $q->setGroupBy("p.id");
                    $this->_debug($q->getQuery());
                    $res = new Query($q);
                    if($res->getTotal() > 0){
                        $this->distributor_id = $distributor_id;
                        $this->parent_product = $res->getResult(0, "parent_product");

                        if($this->parent_product == 0) $form = $this->getForm();
                        else $form = $this->getChildForm();

                        foreach($form->fields as $f){
                            $this->{$f->name} = $res->getResult(0, $f->dbname);
                        }

                        if($this->parent_product == 0 && $res->getResult(0, "child_stock_qty") != ""){
                            $this->stock_qty = $res->getResult(0, "child_stock_qty");
                        }else{
                            $this->stock_qty = $res->getResult(0, "stock_qty");
                        }

                        $this->status = $res->getResult(0, "status");
                        $this->availability_name = $res->getResult(0, "availability_name");
                        $this->cost = $res->getResult(0, "cost");
                        $this->availability_id = $this->outofstockstatus_id;

                        $this->encode_inventory_id = $this->inventory_id = $res->getResult(0, "inventory_id");
                        $this->inventory_id = Inventory::decodeInvId($this->inventory_id);

                        $this->basics_result = $res;

                        if($this->load_inv){
                            $this->_getCalculatedAvailability();
                        }

                        if(!$basics_only){
                            $this->loadNonBasics();
                        }

                        $this->loaded = true;
                        return true;
                    }else{
                        $this->err(_t("Product with that distributor could not be found"));
                    }
                    return false;
                }
     */
}
