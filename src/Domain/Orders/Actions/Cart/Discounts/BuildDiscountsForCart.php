<?php

namespace Domain\Orders\Actions\Cart\Discounts;

class BuildDiscountsForCart
{
    /*
     *
            function buildDiscounts($customer=false){
                if($customer) $this->customer = $customer;

                $this->removeDiscounts();
                $this->shipping_discounts = array();
                $this->product_discounts = array();
                $this->order_discounts = array();

                if($this->getQtyTotal() > 0){

                    $checked = array();

                    $q = $this->getAvailableDiscountsQuery();
                    //Get Discounts for products in cart
                    $array_product_ids = array();
                    $array_product_types = array();
                    $array_product_atts = array();
                    foreach($this->items as $i){
                        $array_product_ids[$i->get('product_id')] = $i->get('product_id');
                        if($i->get('parent_product') > 0) $array_product_ids[$i->get('parent_product')] = $i->get('parent_product');
                        if($i->get('actual_product_id') > 0) $array_product_ids[$i->get('actual_product_id')] = $i->get('actual_product_id');

                        $array_product_types[$i->type_id] = $i->type_id;
                        if($i->attribute_ids != ""){
                            $atts = explode("|", $i->attribute_ids);
                            foreach($atts as $a){
                                if($a != "") $array_product_atts[$a] = $a;
                            }
                        }
                    }
                    $q->addToQuery(" LEFT JOIN discount_rule_condition_products p ON p.condition_id=c.id");
                    $q->addToQuery(" LEFT JOIN discount_rule_condition_producttypes t ON t.condition_id=c.id");
                    $q->addToQuery(" LEFT JOIN discount_rule_condition_attributes a ON a.condition_id=c.id");
                    $qg = new BuildWhereGroup("", "OR");
                    $qg->addWhereToGroup("p.product_id", $array_product_ids, "IN");
                    $qg->addWhereToGroup("t.producttype_id", $array_product_types, "IN");
                    $qg->addWhereToGroup("a.attributevalue_id", $array_product_atts, "IN");
                    $q->addCustomWhere($qg->getGroupQuery());
                    $discounts = new Query($q, "product discounts", 1000);
                    list($result, $checked) = $this->checkDiscounts($discounts);

                    //Get All Other Discounts
                    $q = $this->getAvailableDiscountsQuery($checked);
                    $discounts = new Query($q, "non product discounts", 1000);
                    list($result, $checked) = $this->checkDiscounts($discounts);
                }
            }
     * */
}
