<?php

namespace Domain\Orders\Actions\Cart\Item;

class AddWishlistItemToCart
{
    /*
     *         function loadForAddFromWishlist($id){
                $q = $this->wishlistItemQuery();
                $q->addWhere("i.id", $id);
                $item = new Query($q, "wishlist item", 1);
                if($item->getTotal() > 0){
                    $i = $item->results[0];
                    $product_options = $this->wishlistItemOptions($i);
                    $this->wishlistItemCustomFields($i);

                    $_POST['product_id'] = (($i->parent_product > 0) ? $i->parent_product:$i->product_id);
                    //$_POST['parent_product'] = $i->parent_product;
                    $_POST['product_qty'] = 1;
                    $_POST['product_options'] = $product_options;

                    if($i->has_subproducts > 0){
                        $q = $this->wishlistItemQuery();
                        $q->addWhere("i.parent_wishlist_items_id", $id);
                        $subproducts = new Query($q);
                        if($subproducts->getTotal() > 0){
                            foreach($subproducts->results as $p){
                                if($p->accessory_field_id > 0){
                                    $_POST['accessories_field'][] = $p->accessory_field_id."-".$p->product_id;
                                    $_POST['product_option_'.$p->accessory_field_id.'_'.$p->product_id] = $this->wishlistItemOptions($p);
                                }else{
                                    $product_options = $this->wishlistItemOptions($p);
                                    $this->wishlistItemCustomFields($p);
                                }

                                if($p->is_accessory > 0){
                                    $_POST['accessories'][] = $p->product_id;
                                    $_POST['accessory_options'][$p->product_id] = array(
                                        "show_as_option" => ($p->is_accessory == 2) ? 1:0,
                                        "required"=>($p->accessory_required == 1) ? 1:0,
                                        "options"=>$product_options
                                    );
                                }
                            }
                        }
                    }

                    return true;
                }else $this->c_err(_t("Failed to find wishlist item to add to cart"));
                return false;
            }

            function wishlistItemQuery(){
                $q = new BuildSelect("SELECT i.*, p.parent_product, o.options_json, IF(cf.form_id IS NOT NULL, 1, 0) as has_customfields, IFNULL(cw.id, 0) as has_subproducts
    FROM wishlists_items i
    JOIN products p ON p.id=i.product_id
    LEFT JOIN wishlists_items_options o ON o.wishlists_item_id=i.id
    LEFT JOIN wishlists_items_customfields cf ON cf.wishlists_item_id=i.id
    LEFT JOIN wishlists_items cw ON cw.parent_wishlist_items_id=i.id");
                return $q;
            }
            function wishlistItemOptions($i){
                $product_options = array();
                if($i->options_json != "") $product_options = json_decode(htmlspecialchars_decode($i->options_json), true);
                if(count($product_options) > 0){//see if options have custom values
                    $check_options = array();
                    foreach($product_options as $opt) foreach($opt as $o) $check_options[] = $o;
                    $q = new BuildSelect("SELECT * FROM wishlists_items_options_customvalues");
                    $q->addWhere("wishlists_item_id", $i->id);
                    $q->addWhere("option_id", $check_options, "IN");
                    $cv = new Query($q, "custom values", 500);
                    if($cv->getTotal() > 0){
                        foreach($cv->results as $c){
                            $product_options['custom_values'][$c->option_id] = $c->custom_value;
                        }
                    }
                }
                return $product_options;
            }
            function wishlistItemCustomFields($i){
                if($i->has_customfields > 0){//load custom fields values
                    $product_id = ($i->parent_product > 0) ? $i->parent_product:$i->product;
                    $_POST['cfld'][$product_id] = array();
                    $q = new BuildSelect("SELECT scf.value, scf.form_id, scf.section_id, scf.field_id, cf.display FROM wishlists_items_customfields scf JOIN custom_fields cf ON cf.id=scf.field_id");
                    $q->addWhere("scf.wishlists_item_id", $i->id);
                    $custom_fields = new Query($q, "custom fields", 100);
                    foreach($custom_fields->results as $cf){
                        $_POST['cfld'][$product_id][$cf->form_id][$cf->section_id][$cf->field_id] = $cf->value;
                    }
                }
            }
     */
}
