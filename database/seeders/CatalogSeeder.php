<?php

namespace Database\Seeders;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\ProductForm;
use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Domain\Distributors\Models\Distributor;
use Domain\Locales\Models\Language;
use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateModule;
use Domain\Modules\Models\ModuleTemplateSection;
use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeSetAttribute;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionTranslation;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValueTranslation;
use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Products\Models\Product\Pricing\PricingRuleLevel;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use Domain\Products\Models\Product\ProductAccessoryField;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Products\Models\Product\ProductRelated;
use Domain\Products\Models\Product\ProductReview;
use Domain\Products\Models\Product\ProductTranslation;
use Domain\Products\Models\Product\ProductType;
use Domain\Products\Models\Product\ProductTypeAttributeSet;
use Domain\Products\Models\Product\ProductVariantOption;
use Domain\Products\Models\Product\Settings\ProductSettings;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Domain\Tax\Models\TaxRule;
use Domain\Tax\Models\TaxRuleProductType;

class CatalogSeeder extends AbstractSeeder
{
    public function run()
    {
        $modules = Module::all();
        $moduleTemplates = ModuleTemplate::all();
        $layoutSections = LayoutSection::all();
        AccessoryField::factory(100)->create();
        foreach ($modules as $module) {
            ModuleField::factory(rand(2, 5))->create(['module_id' => $module->id]);

            foreach ($moduleTemplates as $moduleTemplate) {

                foreach ($layoutSections as $layoutSection) {
                    $breakValue = rand(1, 5);
                    if ($breakValue == 3)
                        ModuleTemplateModule::factory()->create(['template_id' => $moduleTemplate->id, 'section_id' => $layoutSection->id, 'module_id' => $module->id]);
                }
                $breakValue = rand(1, 2);
                if ($breakValue == 2) {
                    break;
                }
            }
        }

        //$this->call([AccountTypeSeeder::class]);
        //AccountType::factory(100)->create();

        $discountLevels = DiscountLevel::factory(30)->create();

        foreach ($moduleTemplates as $moduleTemplate) {

            foreach ($layoutSections as $layoutSection) {
                $breakValue = rand(1, 4);
                if ($breakValue == 2)
                    ModuleTemplateSection::factory()->create(['template_id' => $moduleTemplate->id, 'section_id' => $layoutSection->id]);
            }
        }

        $pricingRules = PricingRule::factory(30)->create();
        foreach ($pricingRules as $value) {
            PricingRuleLevel::factory(30)->create(['rule_id' => $value->id]);
        }
        $this->createMemberShipLevel();
        Site::factory(3)->create();
        $sites = Site::all();
        $distributors = Distributor::all();
        Product::factory(30)->create(['default_distributor_id' => $distributors[0]->id]);
        $products = Product::all();

        foreach ($products as $key => $value) {
            $product = Product::find($value->id);
            $product->combined_stock_qty = 0;
            $product->save();
            Product::factory(rand(2, 5))->create(['parent_product' => $value->id, 'default_distributor_id' => $distributors[0]->id]);
        }

        $products = Product::all();
        if (count($distributors) > 0)
            foreach ($products as $value) {
                $productDistributor = ProductDistributor::factory()->create(['product_id' => $value->id, 'distributor_id' => $distributors[0]->id]);
                $product = Product::find($value->id);
                $product->combined_stock_qty = $productDistributor->stock_qty;
                $product->save();
                if ($value->parent_product) {
                    $product = Product::find($value->parent_product);
                    $product->combined_stock_qty = $product->combined_stock_qty + $productDistributor->stock_qty;
                    $product->save();
                }
            }

        CategorySettingsTemplate::factory(10)->create();

        $types = ProductType::factory(30)->create();
        $brands = Brand::factory(30)->create();
        $categories = Category::factory(30)->create();
        $attributes = Attribute::factory(5)->create();

        $attributeOptions = [];
        foreach ($attributes as $attribute) {
            $attributeOptions[] = AttributeOption::factory()->create(['attribute_id' => $attribute->id]);
        }
        $customForms = CustomForm::factory(100)->create();

        $productCount = count($products);
        $customFormCount = count($customForms);
        $taxRules = TaxRule::factory(6)->create();

        $this->createAttribute($types, $taxRules);
        foreach ($attributeOptions as $attributeOption) {
            ProductReview::factory(rand(1, 2))->create(['item_type' => 1, 'item_id' => $attributeOption->id]);
        }

        $languages = Language::all();

        foreach ($products as $key => $value) {
            foreach ($languages as $language) {
                ProductTranslation::factory()->create(['product_id' => $value->id, 'language_id' => $language->id]);
            }
            $rand = rand(0, 29);
            $productType = $types[$rand];
            $discountLevel = $discountLevels[$rand];
            DiscountLevelProduct::factory()->create(['product_id' => $value->id, 'discount_level_id' => $discountLevel->id]);
            $productDetail = ProductDetail::where('product_id', $value->id)->exists();
            if (!$productDetail)
                ProductDetail::factory()->create(
                    [
                        'product_id' => $value->id,
                        'type_id' => $productType->id,
                        'brand_id' => $brands[$rand]->id,
                        'default_category_id' => $categories[$rand]->id,
                    ]
                );
            $attributeSets = $productType->attributeSets;
            foreach ($attributeSets as $attributeSet) {
                $options = AttributeSet::find($attributeSet->id)->options;
                try {
                    ProductAttribute::factory()->create([
                        'option_id' => $options[rand(0, count($options) - 1)]->id,
                        'product_id' => $value->id
                    ]);
                } catch (\Throwable $th) {
                }
            }
            $productOptionType = ProductOptionTypes::Select;
            $productOptionType2 = ProductOptionTypes::Checkbox;

            $productOptions = [];
            $productOptions[] = ProductOption::factory()->create(['product_id' => $value->id, 'type_id' => $productOptionType]);
            $productOptions[] = ProductOption::factory()->create(['product_id' => $value->id, 'type_id' => $productOptionType2]);

            foreach ($productOptions as $productOption) {
                foreach ($languages as $language) {
                    ProductOptionTranslation::factory()->create(['product_option_id' => $productOption->id, 'language_id' => $language->id]);
                }
                $productOptionValues = ProductOptionValue::factory(rand(2, 4))->create(['option_id' => $productOption->id]);
                foreach ($productOptionValues as $productOptionValue) {
                    foreach ($languages as $language) {
                        ProductOptionValueTranslation::factory()->create(['product_option_value_id' => $productOptionValue->id, 'language_id' => $language->id]);
                    }
                }
                if ($value->parent_product != null) {
                    foreach ($productOptionValues as $productOptionValue) {
                        ProductVariantOption::factory()->create(['product_id' => $value->id, 'option_id' => $productOptionValue->id]);
                    }
                }
            }
            foreach ($sites as $site)
                ProductPricing::factory()->create(['product_id' => $value->id, 'site_id' => $site->id]);
            if ($value->parent_product == null)
                ProductPricing::factory()->create(['product_id' => $value->id, 'site_id' => null]);
            ProductReview::factory(rand(1, 5))->create(['item_type' => 0, 'item_id' => $value->id]);
            ProductSettings::factory()->create(['product_id' => $value->id]);
            //ProductSiteSettings::factory()->create(['product_id' => $value->id]);
            //ProductSiteSettings::factory()->create(['product_id' => $value->id,'site_id'=>null]);
            ProductAccessoryField::factory()->create(['product_id' => $value->id]);
            //ProductForm::factory()->create(['product_id' => $value->id]);
            ProductAttribute::factory()->create(['product_id' => $value->id, 'option_id' => $attributeOptions[rand(0, 4)]->id]);

            for ($i = 0; $i < rand(1, 5); $i++) {
                $pRand = $this->rand($key, $productCount);
                $cRand = $this->rand(-1, $customFormCount);
                ProductForm::factory()->create(['product_id' => $value->id, 'form_id' => $customForms[$cRand]->id]);
                ProductAccessory::factory()->create(['product_id' => $value->id, 'accessory_id' => $products[$pRand]->id]);
                ProductRelated::factory()->create(['product_id' => $value->id, 'related_id' => $products[$pRand]->id]);
            }
        }
    }

    private function createAttribute($types, $taxRules)
    {
        $attributeSets = AttributeSet::factory(10)->create();
        $attributes = Attribute::all();
        foreach ($taxRules as $value) {
            foreach ($types as $type) {
                if (rand(0, 1) == 1)
                    TaxRuleProductType::factory()->create(['tax_rule_id' => $value->id, 'type_id' => $type->id]);
            }
        }
        foreach ($attributeSets as $value) {
            foreach ($types as $type) {
                if (rand(0, 1) == 1)
                    ProductTypeAttributeSet::factory()->create(['set_id' => $value->id, 'type_id' => $type->id]);
            }

            AttributeSetAttribute::factory()->create(['attribute_id' => $attributes[rand(0, 11)]->id, 'set_id' => $value->id]);
            AttributeSetAttribute::factory()->create(['attribute_id' => $attributes[rand(12, 22)]->id, 'set_id' => $value->id]);
        }
    }

    private function rand($exclude, $count)
    {
        do {
            $n = mt_rand(0, $count - 1);
        } while ($n == $exclude);

        return $n;
    }

    private function createMemberShipLevel()
    {
        // $levels = [
        //     'Annual Enterprise Membership',
        //     'Annual Medallion Membership',
        //     'Annual Travel Membership',
        //     'Annual Basic Membership',
        // ];
        // foreach ($levels as $level) {
        //     $product = Product::factory()->create([
        //         'title' => $level,
        //     ]);
        //     MembershipLevel::factory()->create([
        //         'annual_product_id' => $product->id
        //     ]);
        // }
    }
}
