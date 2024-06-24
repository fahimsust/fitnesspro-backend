<?php

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Addresses\Models\Address;
use Domain\Affiliates\Models\Affiliate;
use Domain\Distributors\Models\Shipping\old\DistributorCanadaPost;
use Domain\Distributors\Models\Shipping\old\DistributorEndicia;
use Domain\Distributors\Models\Shipping\old\DistributorFedEx;
use Domain\Distributors\Models\Shipping\old\DistributorGenericShipping;
use Domain\Distributors\Models\Shipping\old\DistributorShipStation;
use Domain\Distributors\Models\Shipping\old\DistributorUps;
use Domain\Distributors\Models\Shipping\old\DistributorUsps;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Shipments\OrderShippingAddress;
use Domain\Orders\Models\Order\Transactions\OrderBillingAddress;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Orders\Models\Order\Transactions\OrderTransactionBillingAddress;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Support\Traits\HasMigrationUtilities;

return new class extends Migration {
    use HasMigrationUtilities;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add new foreign keys
        Schema::table(Account::Table(), function (Blueprint $table) {
            if ($this->hasForeignKey($table->getTable(), 'accounts_default_shipping_id_foreign')) {
                $table->dropForeign('accounts_default_shipping_id_foreign');
                $table->dropForeign('accounts_default_billing_id_foreign');
            }

            $table->foreign('default_billing_id')
                ->on(AccountAddress::Table())
                ->references('id');

            $table->foreign('default_shipping_id')
                ->on(AccountAddress::Table())
                ->references('id');
        });

        Schema::table(Order::Table(), function (Blueprint $table) {
            if ($this->hasForeignKey($table->getTable(), 'orders_account_shipping_id_foreign')) {
                $table->dropForeign('orders_account_shipping_id_foreign');
                $table->dropForeign('orders_account_billing_id_foreign');
            }

            if (!$this->hasForeignKey($table->getTable(), 'orders_billing_address_id_foreign'))
                $table->foreign('billing_address_id')
                    ->on(Address::Table())
                    ->references('id');

            if (!$this->hasForeignKey($table->getTable(), 'orders_shipping_address_id_foreign'))
                $table->foreign('shipping_address_id')
                    ->on(Address::Table())
                    ->references('id');
        });

        Schema::table(OrderTransaction::Table(), function (Blueprint $table) {
            if ($this->hasForeignKey($table->getTable(), 'orders_transactions_account_billing_id_foreign')) {
                $table->dropForeign('orders_transactions_account_billing_id_foreign');
            }

            if (!$this->hasForeignKey($table->getTable(), 'orders_transactions_billing_address_id_foreign'))
                $table->foreign('billing_address_id')
                    ->on(Address::Table())
                    ->references('id');
        });

        //drop orders_billing, orders_shipping, orders_transactions_billing
        foreach ([
                     OrderBillingAddress::Table(),
                     OrderTransactionBillingAddress::Table(),
                     OrderShippingAddress::Table(),
                 ] as $tableName) {
            Schema::dropIfExists($tableName);
        }

        Schema::table(AccountAddress::Table(), function (Blueprint $table) {
            $this->dropForeignIfExists($table, 'accounts_addressbook_country_id_foreign');
            $this->dropForeignIfExists($table, 'accounts_addressbook_state_id_foreign');

            if (!Schema::hasColumn($table->getTable(), 'old_billingid'))
                return;

            $table->dropColumn([
                'old_billingid',
                'old_shippingid',
                'label',
                'company',
                'first_name',
                'last_name',
                'address_1',
                'address_2',
                'city',
                'state_id',
                'country_id',
                'postal_code',
                'email',
                'phone',
                'is_residential'
            ]);
        });

        Schema::table(Affiliate::Table(), function (Blueprint $table) {
            $this->dropForeignIfExists($table, 'affiliates_country_id_foreign');
            $this->dropForeignIfExists($table, 'affiliates_state_id_foreign');

            if (!Schema::hasColumn($table->getTable(), 'address_1'))
                return;

            $table->dropColumn([
                'phone',
                'address_1',
                'address_2',
                'city',
                'state_id',
                'country_id',
                'postal_code',
            ]);
        });

        foreach ([
                     DistributorUps::Table(),
                     DistributorUsps::Table(),
                     DistributorFedEx::Table(),
                     DistributorEndicia::Table(),
                     DistributorCanadaPost::Table(),
                     DistributorGenericShipping::Table(),
                     DistributorShipStation::Table(),
                 ] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $this->dropForeignIfExists($table, $table->getTable() . '_state_id_foreign');
                $this->dropForeignIfExists($table, $table->getTable() . '_country_id_foreign');

                if (!Schema::hasColumn($table->getTable(), 'address_1'))
                    return;

                $table->dropColumn([
                    'company',
                    'phone',
                    'email',
                    'address_1',
                    'address_2',
                    'city',
                    'state_id',
                    'country_id',
                    'postal_code',
                ]);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
