<?php

namespace Domain\Orders\Actions\Cart\Item;

use App\Api\Orders\Resources\Cart\AddItemToCartResource;
use App\Api\Orders\Traits\CanSaveCartToSession;
use Domain\Orders\Actions\Cart\Accessories\AddAccessoriesToCart;
use Domain\Orders\Actions\Cart\Item\Options\SaveOptionsForCartItem;
use Domain\Orders\Actions\Cart\Item\Pricing\CheckAndApplyVolumePricingToCartItem;
use Domain\Orders\Actions\Cart\Item\Qty\AdjustCartItemQty;
use Domain\Orders\Actions\Cart\Item\Qty\CheckQtyLimitsForItemDto;
use Domain\Orders\Actions\CheckItemDtoAvailability;
use Domain\Orders\Actions\CheckItemDtoForRequiredAccessories;
use Domain\Orders\Dtos\AccessoryData;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\ProductAccessory;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Support\Contracts\AbstractAction;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Traits\ActionExecuteReturnsStatic;
use Support\Traits\HasExceptionCollection;

class AddItemToCartFromDto extends AbstractAction
    implements CanReceiveExceptionCollection
{
    use ActionExecuteReturnsStatic,
        HasExceptionCollection,
        CanSaveCartToSession;

    public CartItem|Model $cartItem;

    public bool $updatedExistingItem = false;
    private Site $site;
    private Collection $productAccessories;

    public function __construct(
        public Cart        $cart,
        public CartItemDto $cartItemDto,
        public bool        $checkAvailability = true,
        public bool        $checkRequiredAccessories = true,
    )
    {
        $this->site = $this->cartItemDto->site;
    }

    public function result(): CartItem
    {
        return $this->cartItem;
    }

    public function execute(): static
    {

        $this->checkAvailability();
        $this->checkRequiredAccessories();

        if ($existingCartItem = FindItemAlreadyInCartByDto::now($this->cart, $this->cartItemDto)) {
            //handle existing item
            AdjustCartItemQty::run(
                $existingCartItem,
                $this->cartItemDto->getQty()
            )->transferExceptionsTo($this);

            $this->cartItem = $existingCartItem;
            $this->updatedExistingItem = true;

            return $this;
        }

        $this->cartItemDto->orderQty = CheckQtyLimitsForItemDto::now(
            $this->cartItemDto,
            $this->cartItemDto->getQty()
        )
            ->transferExceptionsTo($this)
            ->qty;

        DB::beginTransaction();

        $this->cartItem = $this->cart
            ->items()
            ->create(
                $this->cartItemDto->toModelArray()
            );

        $this->cart->items->push($this->cartItem);

        SaveOptionsForCartItem::run($this->cartItem, $this->cartItemDto);
        SaveCustomFieldValuesForCartItem::run($this->cartItem, $this->cartItemDto);
        CheckAndApplyVolumePricingToCartItem::run($this->cartItem);

        AddAccessoriesToCart::run(
            $this->cart,
            $this->cartItem,
            $this->cartItemDto->accessories?->each(
                fn(AccessoryData $accessoryData) => $accessoryData->setProductAccessory(
                    $this->productAccessories->firstWhere(
                        fn(ProductAccessory $productAccessory) => $productAccessory->accessory_id === $accessoryData->productId
                    )
                )
            )
        );

        //todo maybe later
        //accessory fields
//        AddAccessoryFieldsToCart::run(
//            $this->cart,
//            $this->cartItemDto
//        )
//            ->transferExceptionsTo($this);

        DB::commit();

        return $this;
    }

    public function checkAvailability(): void
    {
        if (!$this->checkAvailability) {
            return;
        }

        CheckItemDtoAvailability::now(
            $this->site,
            $this->cartItemDto,
            $this->cart->account
        );
    }

    public function checkRequiredAccessories(): void
    {
        if (!$this->checkRequiredAccessories) {
            return;
        }

        $this->productAccessories = CheckItemDtoForRequiredAccessories::now(
            $this->cartItemDto,
        );
    }

    public function resultAsResource(): AddItemToCartResource
    {
        return new AddItemToCartResource($this);
    }
    /*
//     *        function add($product_id, $product_qty = 1, $product_options = array(), $parent_cart_id=0, $parent_product = 0, $required = 0, $registry_item_id=0, $accessory_field_id=0, $required_accessories = array(), $distributor_id=0, $update_order=true){
//
//                $new_item = new CartItem($this->customer);
//                $new_item->distributor_id = $distributor_id;
//                if($new_item->initItem($new_id, $product_id, $product_qty, $product_options, $parent_cart_id, $parent_product, $required, $registry_item_id, $accessory_field_id)){
//                    $new_item->required_accessories = $required_accessories;
//                    if(!$new_item->allowOrderAvailability()){
//                        $this->c_err(sprintf(_t("Sorry, %s is not currently available to order."), $new_item->title));
//                        return false;
//                    }
//
//                    if(!$new_item->checkOrderingRule($this->customer)){
//                        $this->getModelErrs($new_item);
//                        return false;
//                    }
//
//                    $new_item->setCustomFieldsValues($_POST['cfld'][$product_id]);
//
//                    unset($this->item_adjusted);
//                    $qty = $product_qty;
//                    $already_id = 0;
//                    $qty_left = $new_item->max_qty;
//                    $matches_exceptdistributor = 0;
//                    foreach($this->items as $unique_id=>$item){
//                        if($item->free_from_discount_advantage == 0){
//                            if($new_item->actual_product_id == $item->actual_product_id
    && $new_item->registry_item_id == $item->registry_item_id
    && $new_item->accessory_link_actions== $item->accessory_link_actions){
//                                $matches = true;
//
//                                if(is_array($item->get('options')) && is_array($new_item->get('options'))){//if has options, compare if custom values match
//                                    $custom_vals = array();
//                                    foreach($item->get('options') as $opt_key => $opts){
//                                        for($z=0; $z < count($opts['value_display']); $z++){
//                                            if($opts['value_custom_type'][$z] >= 0){
//                                                $custom_vals[$opts['value_id'][$z]] = $opts['value_custom_value'][$z];
//                                            }
//                                        }
//                                    }
//                                    if(count($custom_vals) > 0){//has custom values, check if they are the same
//                                        $new_custom_vals = array();
//                                        foreach($new_item->get('options') as $opt_key => $opts){
//                                            for($z=0; $z < count($opts['value_display']); $z++){
//                                                if($opts['value_custom_type'][$z] >= 0){
//                                                    $new_custom_vals[$opts['value_id'][$z]] = $opts['value_custom_value'][$z];
//                                                }
//                                            }
//                                            if(count($new_custom_vals) > 0){
//                                                if(count(array_diff($custom_vals, $new_custom_vals)) > 0){//found differences in custom vals
//                                                    $matches = false;
//                                                }
//                                            }else $matches = false;//existing item has custom values, new doesn't
//                                        }
//                                    }
//                                    if($matches){//matches to this point
//                                        if(is_array($new_item->custom_fields)){//check if custom field values match
//                                            foreach($new_item->custom_fields as $form_id=>$section){
//                                                foreach($section as $section_id=>$field){
//                                                     foreach($field as $field_id=>$value){
//                                                         if(!isset($item->custom_fields[$form_id][$section_id][$field_id]) || $item->custom_fields[$form_id][$section_id][$field_id] != $value){
//                                                             $matches = false;
//                                                             break 3;
//                                                         }
//                                                     }
//                                                }
//                                            }
//                                        }
//
//                                        if($required != $item->get('required')){
//                                            $matches = false;
//                                        }
//
//                                        if((is_array($required_accessories) && !is_array($item->required_accessories))
//                                            || (!is_array($required_accessories) && is_array($item->required_accessories))
//                                            || is_array($required_accessories) && is_array($item->required_accessories) && count(array_diff($required_accessories, $item->required_accessories)) > 0){
//                                            $matches = false;
//                                            $qty_left -= $item->qty;
//                                        }
//
//                                        if($matches){
//                                            if($new_item->distributor_id == $item->distributor_id){
//                                                $already_id = $item->get('id');
//                                                $new_item->setId($already_id);
//                                                $qty_left -= $item->qty;
//                                            }else{
//                                                $matches_exceptdistributor = $item->qty;
//                                            }
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
//
//                    //If product has a min qty setting
//                    if($new_item->min_qty > 1){
//                        $err = sprintf(_t("Minimum qty for the added item is %1s.  We have adjusted your order to meet this requirement."), $new_item->min_qty);
//
//                        //if item already in cart, if less than min qty (even with this add), set to min
//                        if($already_id > 0){
//                            if(($this->items[$already_id]->qty + $qty) < $new_item->min_qty){
//                                $qty = ($new_item->min_qty - $this->items[$already_id]->qty);
//                                $this->c_err($err);
//                                $this->just_adjusted[$new_item->get("id")] = $err;
//                                $this->item_adjusted[] = $err.'->'.$already_id.'->'.$this->items[$already_id]->qty.'->'.$qty.'->'.$new_item->min_qty;
//                            }
//                        }else{
//                            $check_qty = $qty + $matches_exceptdistributor;
//                            if($check_qty < $new_item->min_qty){
//                                $this->c_err($err);
//                                $this->just_adjusted[$new_item->get("id")] = $err;
//                                $this->item_adjusted[] = $err;
//                                $add_qty = $new_item->min_qty - $check_qty;
//                                $qty += $add_qty;
//                            }
//                        }
//                    }
//
//                    //If product has a max qty setting
//                    if($new_item->max_qty > 0){
//                        if($qty_left <= 0){
//                            if($already_id > 0){
//                                $msg = sprintf(_t("Sorry, you already have the maximum allowed quantity of %1s in your cart."), $new_item->title);
//                                $this->just_errored[$already_id] = $msg;
//                                $this->c_err($msg);
//                            }else{
//                                $msg = sprintf(_t("Sorry, you've exceeded the maxiumum allowed purchase quantity of %1s."), $new_item->title);
//                                $this->just_errored[$new_item->get('id')] = $msg;
//                                $this->c_err($msg);
//                            }
//                            return false;
//                        }else{
//                            $check_qty = $qty + $matches_exceptdistributor;
//                            if($check_qty > $qty_left){
//                                $diff = $check_qty - $qty_left;
//                                $new_qty = $qty - $diff;
//                                if($new_qty > 0){
//                                    if($already_id > 0){
//                                        $msg = sprintf(_t("With the items already in your cart, %1s exceeded the maximum qty allowed for purchase.  We've adjusted your order to meet this requirement."), $new_item->title);
//                                        $this->just_adjusted[$already_id] = $msg;
//                                        $this->c_err($msg);
//                                    }else{
//                                        $msg = $new_item->title." ".(($text = Content::getElementByTitle_tags('Quantity exceeds max')) ? $text:_t("quantity exceeds the current quantity available, so we've updated it to the quantity that is available."));
//                                        $this->just_adjusted[$new_item->get("id")] = $msg;
//                                        $this->c_err($msg);
//                                    }
//                                    $qty = $new_qty;
//                                }else{
//                                    $msg = sprintf(_t("Sorry, you already have the maximum allowed quantity of %1s in your cart."), $new_item->title);
//                                    $this->just_errored[$new_item->get('id')] = $msg;
//                                    $this->c_err($msg);
//                                    return false;
//                                }
//                            }
//                        }
//                    }
//
//                    if($already_id > 0){// && $parent_cart_id == 0){
//                        if($this->type == "standard"){
//                            $msg = sprintf(_t("%1s was already in your cart, so we've just adjusted the quantity of that item for you."),$new_item->title);
//                            $this->just_adjusted[$already_id] = $msg;
//                            $this->c_msg($msg);
//                        }
//                        $this->items[$already_id]->qty += $qty;
//                        $total_item_qty = $this->items[$already_id]->qty;
//                        $itemObj = $this->items[$already_id];
//                        $this->last_id = $already_id;
//                    }else{
//                        if($this->type == "standard") $this->c_msg(sprintf(_t("%1s has been added to your cart"), $new_item->title));
//                        $new_item->qty = $qty;
//                        $total_item_qty = $qty;
//                        $this->items[$new_id] = $new_item;
//                        $itemObj = $new_item;
//                        $this->last_id = $new_id;
//                    }
//
//                    $itemObj->checkApplyVolumePricing($total_item_qty);
//
//                    $this->just_added[] = array(
//                        "id"=>$new_item->get('id'),
//                        "title"=>$new_item->title,
//                        "qty" => $new_item->qty,
//                        "price" => $new_item->price,
//                        "type" => $new_item->type_name,
//                        "brand" => $new_item->brand_name,
//                        "item_adjusted" => $this->item_adjusted
//                    );
//
//                    $this->last_qty = $qty;
//                    $this->qty += $qty;
//
//                    if($update_order) $this->updateOrder();
//                    return $new_item;
//                }else $this->getModelErrs($new_item);
//                return false;
//            }
//            function add_freeitem($advantage_id, $product_id, $product_qty = 1, $product_options = array(), $parent_cart_id=0, $parent_product = 0, $required = 0, $registry_item_id=0){
//                if(!($product_qty > 0)) $product_qty = 1;
//                $new_id = rand(1000, 99999);
//                $new_item = new CartItem();
//                if($new_item->initItem($new_id, $product_id, $product_qty, $product_options, $parent_cart_id, $parent_product, $required, $registry_item_id)){
//                    $new_item->free_from_discount_advantage = $advantage_id;
//                    $this->items[$new_id] = $new_item;
//                    $itemObj = $new_item;
//                    $this->last_id = $new_id;
//
//                    $this->last_qty = $product_qty;
//                    $this->qty += $product_qty;
//
//                    return $new_item;
//                }
//                return false;
//            }
//
//            function add_item($product_id, $product_qty = 1, $product_options = array(), $parent_cart_id=0, $parent_product = 0, $required = 0, $registry_item_id=0, $distributor_id=0, $update_order=true){
//                $required_accessories = array();
//                if(is_array($_POST['accessories'])){
//                    foreach($_POST['accessories'] as $accessory){
//                        if($_POST['accessory_options'][$accessory]['required']){
//                            $required_accessories[] = $accessory."_".serialize($_POST['accessory_options'][$accessory]['options']);
//                        }
//                    }
//                }
//
//                if($newItem = $this->add($product_id, $product_qty, $product_options, $parent_cart_id, $parent_product, $required, $registry_item_id, 0, $required_accessories, $distributor_id, $update_order)){          $failed = false;
//                    if(!$newItem->addAccessoriesFields_ToCart($this)){
//                        $failed = true;
//                    }
//
//                    if(is_array($_POST['accessories'])){
//                        $_POST['child_of'] = 0;//unset to accessory doesn't use it
//                        foreach($_POST['accessories'] as $accessory){
//                            if($_POST['accessory_options'][$accessory]['show_as_option'] == 1){
//                                $parent_cart_id = $newItem->get('id');
//                                $parent_product = $product_id;
//                                $qty = $this->last_qty;
//                            }else{
//                                $parent_product = 0;
//                                $parent_cart_id = 0;
//                                $qty = $product_qty;
//                            }
//                            if($_POST['accessory_options'][$accessory]['required']){
//                                $required = $newItem->get('id');
//                            }
//
//                            if(!$required && SEPARATE_QTY_FOR_NONREQUIRED_ACCESSORY === true){
//                                $sep_qty = $_POST['accessory_product_qty_'.$accessory];
//                                if($sep_qty > 0) $qty = $sep_qty;
//                            }
//
//                            if($newestItem = $this->add($accessory, $qty, $_POST['accessory_options'][$accessory]['options'], $parent_cart_id, $parent_product, $required)){
//                                if($_POST['accessory_options'][$accessory]['link_actions'] == 1){
//                                    $newestItem->accessoryLinkActions($newItem->get("id"));
//                                }
//                                //don't need this, msg added in add function //$this->c_msg(sprintf(_t("%1s has been added to your cart"), $newestItem->title));
//                            }else{
//                                $failed = true;
//                            }
//                        }
//                    }
//
//                    $_SESSION['last_added_product'] = $_POST['product_id'];
//                    $this->new_item = $newItem;
//                    if($this->type == "standard" && $update_order){
//                        $this->save();
//                        $this->updateOrder();
//                    }
//                    return true;
//                }
//                return false;
//            }
     */
}
