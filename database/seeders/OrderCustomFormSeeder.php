<?php

namespace Database\Seeders;


use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Domain\CustomForms\Models\FormSectionField;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderCustomForm;
use Domain\Products\Models\Product\Product;
use Faker\Factory as Faker;

class OrderCustomFormSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $orders = Order::limit(10)->orderBy('id','asc')->get();
        $products = Product::limit(10)->with('details')->orderBy('id','asc')->get();
        $customForms = CustomForm::all();
        foreach($orders as $key=>$order)
        {
            $customForm = $customForms[rand(0,count($customForms))];
            $hasSection = FormSection::where('form_id',$customForm->id)->exists();
            $formValue = [];
            $formValue2 = [];
            $productType = $this->productHasType($products,$key);
            if(!$hasSection)
            {
                $sections = FormSection::factory(rand(2,3))->create(['form_id'=>$customForm->id]);
                foreach($sections as $section)
                {
                    $field = CustomField::factory()->create();
                    FormSectionField::factory()->create(
                        [
                            'section_id'=>$section->id,
                            'field_id'=>$field->id
                        ]
                    );
                    $formValue[$customForm->id][$section->id][$field->id] = $faker->name;
                    if($productType)
                    {
                        $formValue2[$customForm->id."-".$productType[0]."-".$productType[1]][$section->id][$field->id] = $faker->name;
                    }
                
                }
            }
            OrderCustomForm::factory()->create([
                'form_id'=> $customForm->id,
                'order_id'=>$order->id,
                'product_id'=>null,
                'product_type_id'=>null,
                'form_count'=>0,
                'form_values'=>$formValue
            ]);
            if($productType)
            {
                OrderCustomForm::factory()->create([
                    'form_id'=> $customForm->id,
                    'order_id'=>$order->id,
                    'product_id'=>$productType[0],
                    'product_type_id'=>$productType[1],
                    'form_count'=>0,
                    'form_values'=>$formValue2
                ]);
            }
            

        }
            
    }
    private function productHasType($products,$key)
    {
        if($products[$key] && $products[$key]->details && $products[$key]->details->type_id)
        {
            return [$products[$key]->id,$products[$key]->details->type_id];
        }
        return false;
    }
}
