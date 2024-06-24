<?php

namespace Domain\Orders\Actions\Order\Package\Item;

class UpdateOrderItemCustomsInfo
{
    /*
     *     function updateCustomsInfo(){
            $changed = false;
            $form = $this->customsFields();
            foreach($form->fields as $f){
                $_POST[$f->name] = $_POST[$f->name."s"][$this->id];
                if($f->val() != $this->{$f->name}) $changed = true;
            }
            if($changed){
                $i = new BuildInsert("INSERT INTO orders_products_customsinfo");
                $i->addInsert("orders_products_id", $this->id);
                foreach($form->fields as $f) $i->addInsert($f->dbname, $f->val());
                $i->onDuplicateUpdate();
                if($i->exec()){
                    return true;
                }else $this->c_err(_t("Failed to set customs info").": ".db()->error());
                return false;
            }
            return true;
        }
     */
}
