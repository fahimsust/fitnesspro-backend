<?php

namespace Database\Seeders;

use Domain\Locales\Models\Currency;

class CurrencySeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->bulkCreate(
            Currency::class,
            ['id', 'name', 'code', 'status', 'exchange_rate', 'exchange_api', 'base', 'decimal_places', 'decimal_separator', 'locale_code', 'format', 'symbol'],
            [
                [1, 'US Dollar ($)', 'USD', 1, 0.00000, 0, 1, 2, '.', 'en_US', null, null],
                [2, 'UAE Dirham', 'AED', 1, 3.67300, 0, 0, 3, '.', 'ar_AE', null, null],
                [3, 'Bahrain Dinar', 'BHD', 1, 0.36730, 0, 0, 3, '.', 'ar_BH', null, null],
                [4, 'British Pound', 'GBP', 0, 1.00000, 0, 0, 2, '.', 'en_GB', null, null],
                [5, 'Euro', 'EUR', 0, 1.00000, 0, 0, 2, ',', 'nl_NL', null, null],
            ]
        );
    }
}
