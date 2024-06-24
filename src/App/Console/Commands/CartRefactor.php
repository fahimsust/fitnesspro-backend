<?php

namespace App\Console\Commands;

use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountOld;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Orders\Models\Carts\CartItems\CartItemOptionOld;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CartRefactor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CartRefactor:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cart Refactor Command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $progressbar = $this->output->createProgressBar(3);

        $progressbar->start();
        $this->output->write('<info>Update Foreign Key Data</info>');
        $this->updateForeignData();
        $progressbar->advance();

        $this->output->write('<info>Run Migrate</info>');
        Artisan::call('migrate');
        $progressbar->advance();

        $this->output->write('<info>Modifiy Data/info>');
        $this->modifyAndDropCartItemOption();
        $this->convertCartDiscountCodes();

        Schema::dropIfExists('cart_items_options_customvalues');

        $progressbar->finish();
    }

    private function updateForeignData()
    {
        //        DB::statement("UPDATE cart_items SET parent_cart_item_id = null WHERE parent_cart_item_id NOT EXISTS (SELECT id FROM cart_items)");
        //        DB::statement("UPDATE cart_items SET required = null WHERE required NOT EXISTS (SELECT id FROM cart_items)");
        //        DB::statement("UPDATE cart_items SET accessory_link_actions = null WHERE accessory_link_actions NOT EXISTS (SELECT id FROM cart_items)");

        Schema::table(CartItem::Table(), function (Blueprint $table) {
            $table->unsignedBigInteger('required')->nullable()->change();
            $table->unsignedBigInteger('accessory_link_actions')
                ->nullable()
                ->change();
        });
        $child_data = DB::select('select id from `cart_items`');
        $ids = [];
        foreach ($child_data as $value) {
            $ids[] = $value->id;
        }

        //updating because the array was empty for me and caused the query to fail
        $query = 'UPDATE `cart_items` set `parent_cart_id` = NULL where `parent_cart_id` is not null';
        if (count($ids)) {
            $query .= ' and `parent_cart_id` not in (' . implode(',', $ids) . ')';
        }

        DB::statement($query);

        $query = 'UPDATE `cart_items` set `required` = NULL where `required` is not null';
        if (count($ids)) {
            $query .= ' and `required` not in (' . implode(',', $ids) . ')';
        }

        DB::statement($query);

        $query = 'UPDATE `cart_items` set `accessory_link_actions` = NULL where `accessory_link_actions` is not null';
        if (count($ids)) {
            $query .= ' and `accessory_link_actions` not in (' . implode(',', $ids) . ')';
        }

        DB::statement($query);
    }

    private function modifyAndDropCartItemOption()
    {
        $cart_item_options = CartItemOptionOld::all();
        foreach ($cart_item_options as $cart_item_option) {
            $options = $cart_item_option['options_json'];
            foreach ($options as $option) {
                CartItemOption::create(
                    [
                        'item_id' => $cart_item_option['cart_item_id'],
                        'option_value_id' => $option[0],
                    ]
                );
            }
        }
        Schema::dropIfExists('cart_items_options');
    }

    private function convertCartDiscountCodes()
    {
        $cartDiscounts = CartDiscountOld::all();
        foreach ($cartDiscounts as $cartDiscount) {
            $discountCodes = $cartDiscount['applied_codes_json'];
            foreach ($discountCodes as $discountCode) {
                $discountCondition = DiscountCondition::where('required_code', $discountCode)->first();
                if ($discountCondition) {
                    CartDiscountCode::create(
                        [
                            'cart_id' => $cartDiscount['cart_id'],
                            'code' => $discountCode,
                            'condition_id' => $discountCondition->id,
                        ]
                    );
                }
            }
        }
    }
}
