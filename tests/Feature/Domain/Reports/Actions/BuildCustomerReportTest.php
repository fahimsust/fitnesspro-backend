<?php

namespace Tests\Feature\Domain\Reports\Actions;

use Carbon\Carbon;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Reports\Actions\BuildCustomerReport;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Accounts\Models\AccountSpecialty;
use Domain\Accounts\Models\AccountType;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Accounts\Models\Specialty;
use Domain\Addresses\Models\Address;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Domain\Orders\Models\Order\Order;
use Domain\Reports\Models\Report;
use Tests\TestCase;

class BuildCustomerReportTest extends TestCase
{
    protected $levelId;
    protected $accountTypes = [];
    protected $states = [];
    protected $specialties = [];
    protected $city = "Dhaka";
    protected $countryId;
    /** @test */
    public function check_membership_level_customer()
    {
        $this->prepareData();
        $criteria = [
            'membership_level' => $this->levelId,
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(4, count($customers));
        $this->assertEquals(3, count($headers));
    }
    /** @test */
    public function check_active_customer()
    {
        $currentDate = Carbon::now();

        $start_date = new Carbon('1 month ago');
        $end_date = $currentDate->addDays(10);
        $this->prepareData();
        $criteria = [
            'account_status' => 5,
            'start_date' => $start_date->toDateTimeString(),
            'end_date' => $end_date->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(4, count($customers));
        $this->assertEquals(3, count($headers));


        $currentDate = Carbon::now();

        $start_date = new Carbon('1 month ago');
        $end_date = $currentDate->addDays(10);
        $criteria = [
            'account_status' => 2,
            'start_date' => $start_date->toDateTimeString(),
            'end_date' => $end_date->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(7, count($customers));
        $this->assertEquals(3, count($headers));


        $criteria = [
            'account_status' => 2,
            'start_date' => $currentDate->addDays(5)->toDateTimeString(),
            'end_date' => $currentDate->addDays(5)->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(0, count($customers));
        $this->assertEquals(3, count($headers));

        $criteria = [
            'account_status' => 2,
            'start_date' => $currentDate->addDays(5)->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(0, count($customers));
        $this->assertEquals(3, count($headers));

        $criteria = [
            'account_status' => 2,
            'end_date' => $currentDate->addDays(5)->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(0, count($customers));
        $this->assertEquals(3, count($headers));
    }

    /** @test */
    public function check_last_login_customer()
    {
        $currentDate = Carbon::now();

        $start_date = new Carbon('1 month ago');
        $end_date = $currentDate->addDays(10);
        $this->prepareData();
        $criteria = [
            'account_status' => 1,
            'start_date' => $start_date->toDateTimeString(),
            'end_date' => $end_date->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(7, count($customers));
        $this->assertEquals(3, count($headers));

        $currentDate = Carbon::now();
        $criteria = [
            'account_status' => 1,
            'start_date' => $currentDate->addDays(5)->toDateTimeString(),
            'end_date' => $currentDate->addDays(25)->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(4, count($customers));
        $this->assertEquals(3, count($headers));

        $currentDate = Carbon::now();
        $criteria = [
            'account_status' => 1,
            'start_date' => $currentDate->addDays(11)->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(4, count($customers));
        $this->assertEquals(3, count($headers));

        $currentDate = Carbon::now();
        $criteria = [
            'account_status' => 1,
            'end_date' => $currentDate->addDays(10)->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(7, count($customers));
        $this->assertEquals(3, count($headers));
    }

    /** @test */
    public function check_membership_customer_created()
    {
        $currentDate = Carbon::now();

        $start_date = new Carbon('1 month ago');
        $end_date = $currentDate->addDays(10);
        $this->prepareData();
        $criteria = [
            'account_status' => 3,
            'start_date' => $start_date->toDateTimeString(),
            'end_date' => $end_date->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(7, count($customers));
        $this->assertEquals(3, count($headers));

        $currentDate = Carbon::now();
        $criteria = [
            'account_status' => 3,
            'start_date' => $currentDate->addDays(11)->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(7, count($customers));
        $this->assertEquals(3, count($headers));

        $this->assertEquals(7, count($customers));
        $this->assertEquals(3, count($headers));

        $currentDate = Carbon::now();
        $criteria = [
            'account_status' => 3,
            'end_date' => $currentDate->addDays(10)->toDateTimeString(),
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(7, count($customers));
        $this->assertEquals(3, count($headers));


    }
    /** @test */
    public function check_account_type_customer()
    {
        $this->prepareData();
        $criteria = [
            'account_type_id' => [$this->accountTypes[0]->id, $this->accountTypes[1]->id],
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(7, count($customers));
        $this->assertEquals(3, count($headers));
    }
    /** @test */
    public function check_account_speciality_customer()
    {
        $this->prepareData();
        $criteria = [
            'specialties' => [$this->specialties[0]->id, $this->specialties[1]->id],
            'specialty_allany'=>0
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(11, count($customers));
        $this->assertEquals(3, count($headers));
        $this->prepareData();
        $criteria = [
            'specialties' => [$this->specialties[0]->id, $this->specialties[1]->id],
            'specialty_allany'=>1
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(4, count($customers));
        $this->assertEquals(3, count($headers));
    }
    /** @test */
    public function check_order_customer()
    {
        $this->prepareData();
        $criteria = [
            'has_ordered'=>1
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(4, count($customers));
        $this->assertEquals(3, count($headers));
        $criteria = [
            'has_ordered'=>2
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(7, count($customers));
        $this->assertEquals(3, count($headers));
    }
    /** @test */
    public function check_travel_order_customer()
    {
        $this->prepareData();
        $criteria = [
            'has_travel_ordered'=>1
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(3, count($customers));
        $this->assertEquals(3, count($headers));
        $criteria = [
            'has_travel_ordered'=>2
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(8, count($customers));
        $this->assertEquals(3, count($headers));
    }
    /** @test */
    public function check_address_customer()
    {
        $this->prepareData();
        $criteria = [
            'ship_to_city'=>$this->city
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(4, count($customers));
        $this->assertEquals(3, count($headers));
        $criteria = [
            'ship_to_country'=>$this->countryId
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(4, count($customers));
        $this->assertEquals(3, count($headers));

        $criteria = [
            'ship_to_state'=>[$this->states[0]->id,$this->states[1]->id]
        ];
        $report = Report::factory()->create([
            'criteria'=>$criteria
        ]);
        [$customers,$headers] = BuildCustomerReport::run((Object)$report->criteria,$report);
        $this->assertEquals(7, count($customers));
        $this->assertEquals(3, count($headers));
    }
    private function prepareData()
    {
        $currentDate = Carbon::now();
        $levels = MembershipLevel::factory(2)->create();
        $countries = Country::factory(2)->create();
        $this->accountTypes = AccountType::factory(10)->create();
        $this->specialties = Specialty::factory(10)->create();
        $this->states = StateProvince::factory(10)->create();
        $this->levelId = $levels->first()->id;
        $this->countryId = $countries->first()->id;
        $address1 = Address::factory()->create([
            'state_id' => $this->states[0]->id,
            'country_id' => $this->countryId,
            'city' => $this->city
        ]);
        $address2 = Address::factory()->create([
            'state_id' => $this->states[1]->id,
            'country_id' => $countries[1]->id,
            'city' => 'chittagong'
        ]);
        $address3 = Address::factory()->create([
            'state_id' => $this->states[2]->id,
            'country_id' => $countries[1]->id,
            'city' => 'sylhet'
        ]);

        $accounts = Account::factory(4)->create([
            'type_id'=> $this->accountTypes->first()->id,
        ]);
        foreach($accounts as $key=>$account)
        {
            Subscription::factory(2)->create([
                'level_id'  =>  $this->levelId,
                'account_id'=>  $account->id,
                'created'=>Carbon::now()
            ]);
            Subscription::factory()->create([
                'level_id'  =>  $this->levelId,
                'account_id'=>  $account->id,
                'status'=>0,
                'created'=>Carbon::now()
            ]);
            AccountSpecialty::factory()->create([
                'account_id'=>$account->id,
                'specialty_id'=> $this->specialties->first()->id,
            ]);
            AccountSpecialty::factory()->create([
                'account_id'=>$account->id,
                'specialty_id'=> $this->specialties[1]->id,
            ]);
            $orders = Order::factory(2)->create([
                'account_id'=> $account->id,
            ]);
            if($key > 0)
            {
                $product = Product::factory()->create();
                $productOption = ProductOption::factory()->create([
                    'product_id'=>$product->id,
                    'type_id'=>ProductOptionTypes::DateRange
                ]);
                ProductOptionValue::factory()->create([
                    'option_id'=>$productOption->id,
                    'start_date'=>Carbon::now(),
                    'end_date'=>Carbon::now()->addDays(30)->toDateTimeString()
                ]);
                OrderItem::factory()->create([
                    'product_id'=>$product->id,
                    'order_id'=>$orders[0]->id,
                ]);
            }
            $accountAddress = AccountAddress::factory()->create([
                'account_id'=>  $account->id,
                'address_id'=>  $address1->id,
            ]);
            $account->update([
                'default_shipping_id' => $accountAddress->id
            ]);

        }
        $accounts = Account::factory(3)->create([
            'type_id'=> $this->accountTypes[1]->id,
        ]);
        foreach($accounts as $account)
        {
            Subscription::factory()->create([
                'level_id'  =>  $levels[1]->id,
                'account_id'=>  $account->id,
            ]);
            Subscription::factory()->create([
                'level_id'  =>  $levels[1]->id,
                'account_id'=>  $account->id,
                'created' => $currentDate->addDays(30)->toDateTimeString(),
            ]);
            AccountSpecialty::factory()->create([
                'account_id'=>$account->id,
                'specialty_id'=> $this->specialties->first()->id,
            ]);
            AccountSpecialty::factory()->create([
                'account_id'=>$account->id,
                'specialty_id'=> $this->specialties[2]->id,
            ]);
            AccountSpecialty::factory()->create([
                'account_id'=>$account->id,
                'specialty_id'=> $this->specialties[3]->id,
            ]);
            $accountAddress = AccountAddress::factory()->create([
                'account_id'=>  $account->id,
                'address_id'=>  $address2->id,
            ]);
            $account->update([
                'default_shipping_id' => $accountAddress->id
            ]);
        }
        $currentDate = Carbon::now();
        $accounts = Account::factory(4)->create([
            'type_id'=> $this->accountTypes[2]->id,
            'lastlogin_at'=>$currentDate->addDays(20)->toDateTimeString()
        ]);
        $currentDate = Carbon::now();
        foreach($accounts as $account)
        {

            $cancel_date = new Carbon('1 year ago');
            Subscription::factory(2)->create([
                'level_id'  =>  $levels[1]->id,
                'account_id'=>  $account->id,
                'cancelled' => $cancel_date->toDateTimeString(),
                'created' => $currentDate->addDays(30)->toDateTimeString(),
            ]);
            AccountSpecialty::factory()->create([
                'account_id'=>$account->id,
                'specialty_id'=> $this->specialties->first()->id,
            ]);
            AccountSpecialty::factory()->create([
                'account_id'=>$account->id,
                'specialty_id'=> $this->specialties[2]->id,
            ]);
            AccountSpecialty::factory()->create([
                'account_id'=>$account->id,
                'specialty_id'=> $this->specialties[3]->id,
            ]);
            $accountAddress = AccountAddress::factory()->create([
                'account_id'=>  $account->id,
                'address_id'=>  $address3->id,
            ]);
            $account->update([
                'default_shipping_id' => $accountAddress->id
            ]);
        }
    }
}
