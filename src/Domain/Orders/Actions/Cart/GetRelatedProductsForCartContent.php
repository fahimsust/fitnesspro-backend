<?php

namespace Domain\Orders\Actions\Cart;

class GetRelatedProductsForCartContent
{
    /*
     *
            function getRelatedProducts($count=10){
                if(count($this->items) > 0){
                    $pq = new ProductQuery();
                    $pq->getRelated();
                    $q = $pq->build();
                    $q->addToSelect("1 as manually_related, ");
                    if(count($this->items) > 0){
                        $q2 = new BuildWhereGroup("", "OR");
                        foreach($this->items as $i){
                            $q2->addWhereToGroup("r.product_id", $i->get("product_id"));
                            $q->addWhere("p.id", $i->get("product_id"), "!=");
                        }
                        $q->addCustomWhere($q2->getGroupQuery());
                    }
                    if(count($this->shown_related) > 0) $q->addWhere("p.id", $this->shown_related, "NOT IN");
                    if(is_object($this->lastadded_product) && count($this->lastadded_product->shown_related) > 0) $q->addWhere("p.id", $this->lastadded_product->shown_related, "NOT IN");
                    if(is_object(ctl()->recentlyViewed) && count(ctl()->recentlyViewed->shown_related) > 0) $q->addWhere("p.id", ctl()->recentlyViewed->shown_related, "NOT IN");
                    $q->setGroupBy("p.id");
                    $q->setLimit($count);
                    $query1 = $q->getQuery();

                    $pq = new ProductQuery(); $q = $pq->build();
                    $q->addToSelect("0 as manually_related, ");
                    if(count($this->items) > 0){
                        $q2 = new BuildWhereGroup("", "OR");
                        foreach($this->items as $i){
                            $q2->addWhereToGroup("pd.type_id", $i->get("type_id"));
                            $q->addWhere("p.id", $i->get("product_id"), "!=");
                        }
                        $q->addCustomWhere($q2->getGroupQuery());
                    }
                    if(count($this->shown_related) > 0) $q->addWhere("p.id", $this->shown_related, "NOT IN");
                    if(is_object($this->lastadded_product) && count($this->lastadded_product->shown_related) > 0) $q->addWhere("p.id", $this->lastadded_product->shown_related, "NOT IN");
                    if(is_object(ctl()->recentlyViewed) && count(ctl()->recentlyViewed->shown_related) > 0) $q->addWhere("p.id", ctl()->recentlyViewed->shown_related, "NOT IN");
                    $q->setGroupBy("p.id");
                    $q->setLimit($count);
                    $query2 = $q->getQuery();

                    $q = new BuildSelect("SELECT * FROM (".$query1." UNION ".$query2.") as tmp");
                    $q->setGroupBy("id");
                    $q->setOrderBy("manually_related DESC");
                    $this->related_products = new Query($q, "related products", $count);
                    return true;
                }else $this->related_products = new Query();
                return false;
            }
     */
}
