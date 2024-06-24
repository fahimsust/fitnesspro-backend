<?php

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
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    use \Support\Traits\HasMigrationUtilities;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        $this->disableForeignKeys();
//        Schema::dropIfExists(Address::Table());
//        $this->enableForeignKeys();

//        if (!Schema::hasTable(Address::Table()))
            Schema::create(Address::Table(), function (Blueprint $table) {
                $table->id();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
                $table->softDeletes();

                $table->string('label', 35);
                $table->string('company', 155)->nullable();
                $table->string('first_name', 55)->nullable();
                $table->string('last_name', 55)->nullable();
                $table->string('address_1', 155);
                $table->string('address_2', 155)->nullable();
                $table->string('city', 35);
                $table->foreignId('state_id')
                    ->nullable()
                    ->constrained(StateProvince::Table());

                $table->foreignId('country_id')
                    ->nullable()
                    ->constrained(Country::Table());

                $table->string('postal_code', 15);
                $table->string('email', 85)->nullable();
                $table->string('phone', 35)->nullable();

                $table->boolean('is_residential')->default(false);

                $table->string('resource_type')->nullable();
                $table->unsignedBigInteger('resource_id')->nullable();

                $table->index(['resource_type', 'resource_id'], 'from_resource');
            });


        foreach ($this->addressAndDistributorTables() as $tableName) {
            if (Schema::hasColumn($tableName, 'address_id'))
                continue;

            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('address_id')
                    ->nullable()
                    ->constrained(Address::Table());
            });
        }

        //move data to addresses table
        DB::statement("INSERT INTO addresses (id, label, company, first_name, last_name, address_1, address_2, city, state_id, country_id, postal_code, email, phone, is_residential, deleted_at, resource_type, resource_id)
SELECT id, label, company, first_name, last_name, address_1, address_2, city, state_id, country_id, postal_code, email, phone, is_residential, IF(status < 1, CURRENT_TIMESTAMP, null), 'accounts_addressbook', id FROM accounts_addressbook");

        DB::statement("INSERT INTO addresses (label, company, first_name, last_name, address_1, address_2, city, state_id, country_id, postal_code, email, phone, is_residential, resource_type, resource_id)
SELECT CONCAT(order_id, ' Billing') as label, bill_company, bill_first_name, bill_last_name, bill_address_1, bill_address_2, bill_city, bill_state_id, bill_country_id, bill_postal_code, bill_email, bill_phone, 0, 'orders_billing', order_id FROM orders_billing");

        DB::statement("INSERT INTO addresses (label, company, first_name, last_name, address_1, address_2, city, state_id, country_id, postal_code, email, phone, is_residential, resource_type, resource_id)
SELECT CONCAT(orders_transactions_id, ' Billing') as label, null, bill_first_name, bill_last_name, bill_address_1, bill_address_2, bill_city, bill_state_id, bill_country_id, bill_postal_code, null, bill_phone, 0, 'orders_transactions_billing', orders_transactions_id FROM orders_transactions_billing");

        DB::statement("INSERT INTO addresses (label, company, first_name, last_name, address_1, address_2, city, state_id, country_id, postal_code, email, phone, is_residential, resource_type, resource_id)
SELECT CONCAT(order_id, ' Shipping') as label, ship_company, ship_first_name, ship_last_name, ship_address_1, ship_address_2, ship_city, ship_state_id, ship_country_id, ship_postal_code, ship_email, ship_phone, is_residential, 'orders_shipping', order_id FROM orders_shipping");

        DB::statement("INSERT INTO addresses (label, company, first_name, last_name, address_1, address_2, city, state_id, country_id, postal_code, email, phone, is_residential, resource_type, resource_id)
SELECT CONCAT(id, ' affiliate address') as label, null, SUBSTRING_INDEX(name, ' ', 1), SUBSTRING_INDEX(name, ' ', -1), address_1, address_2, city, state_id, country_id, postal_code, email, phone, 0, 'affiliates', id FROM affiliates");

        foreach ($this->distributorTablesWithContactName() as $table) {
            DB::statement("INSERT INTO addresses (label, company, first_name, last_name, address_1, address_2, city, state_id, country_id, postal_code, email, phone, is_residential, resource_type, resource_id)
SELECT CONCAT(distributor_id, ' distributor address') label, company, null, null, address_1, address_2, city, state_id, country_id, postal_code, email, phone, 0, '" . $table . "', distributor_id FROM " . $table);
        }

        foreach ($this->distributorTablesWithoutContactName() as $table) {
            DB::statement("INSERT INTO addresses (label, company, first_name, last_name, address_1, address_2, city, state_id, country_id, postal_code, email, phone, is_residential, resource_type, resource_id)
SELECT CONCAT(distributor_id, ' distributor address') label, company, null, null, address_1, address_2, city, state_id, country_id, postal_code, email, phone, 0, '" . $table . "', distributor_id FROM " . $table);
        }

        Schema::table(OrderTransaction::Table(), function (Blueprint $table) {
            if (Schema::hasColumn($table->getTable(), 'account_billing_id')) {
                $table->renameColumn('account_billing_id', 'billing_address_id');
            }

            if($this->hasForeignKey($table->getTable(), 'orders_transactions_account_billing_id_foreign'))
                $table->dropForeign('orders_transactions_account_billing_id_foreign');
        });

        Schema::table(Order::Table(), function (Blueprint $table) {
            if (Schema::hasColumn($table->getTable(), 'account_billing_id')) {
                $table->renameColumn('account_billing_id', 'billing_address_id');
                $table->renameColumn('account_shipping_id', 'shipping_address_id');
            }

            if ($this->hasForeignKey($table->getTable(), 'orders_account_shipping_id_foreign')) {
                $table->dropForeign('orders_account_shipping_id_foreign');
                $table->dropForeign('orders_account_billing_id_foreign');
            }

            if ($this->hasForeignKey($table->getTable(), 'order_billing_address'))
                $table->foreign('billing_address_id', 'order_bill_address')
                    ->on(Address::Table())
                    ->references('id');

            if ($this->hasForeignKey($table->getTable(), 'order_shipping_address'))
                $table->foreign('shipping_address_id', 'order_ship_address')
                    ->on(Address::Table())
                    ->references('id');
        });

        foreach ([
                     ['orders', 'orders_billing', 'billing_address_id'],
                     ['orders', 'orders_shipping', 'shipping_address_id'],
                     ['orders_transactions', 'orders_transactions_billing', 'billing_address_id'],
                 ] as $query) {
            $table = $query[0];
            $resource = $query[1];
            $field = $query[2];

            DB::statement("UPDATE `{$table}` SET `{$table}`.{$field} =
 (SELECT addresses.id FROM addresses WHERE addresses.resource_type='{$resource}' and addresses.resource_id=`{$table}`.id) WHERE `{$table}`.{$field} IS NULL");
        }

        foreach ($this->addressTables() as $table) {
            DB::statement("UPDATE `{$table}` SET address_id =
(SELECT addresses.id FROM addresses WHERE addresses.resource_type='{$table}' and addresses.resource_id=`{$table}`.id) WHERE `{$table}`.address_id IS NULL");
        }

        foreach ($this->distributorTables() as $table) {
            DB::statement("UPDATE `{$table}` SET address_id =
(SELECT addresses.id FROM addresses WHERE addresses.resource_type='{$table}' and addresses.resource_id=`{$table}`.distributor_id) WHERE `{$table}`.address_id IS NULL");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->disableForeignKeys();
        Schema::dropIfExists(Address::Table());
        $this->enableForeignKeys();
    }

    private function addressAndDistributorTables(): array
    {
        return array_merge(
            $this->addressTables()
            , $this->distributorTables()
        );
    }

    private function addressTables(): array
    {
        return [
            AccountAddress::Table(),
            Affiliate::Table(),
        ];
    }

    private function distributorTables(): array
    {
        return array_merge(
            $this->distributorTablesWithContactName()
            , $this->distributorTablesWithoutContactName()
        );
    }

    private function distributorTablesWithoutContactName(): array
    {
        return [
            DistributorUps::Table(),
            DistributorUsps::Table(),
        ];
    }

    private function distributorTablesWithContactName(): array
    {
        return [
            DistributorShipStation::Table(),
            DistributorCanadaPost::Table(),
            DistributorEndicia::Table(),
            DistributorGenericShipping::Table(),
            DistributorFedEx::Table(),
        ];
    }

};
