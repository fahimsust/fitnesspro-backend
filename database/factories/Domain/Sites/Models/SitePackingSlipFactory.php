<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Content\Models\Element;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SitePackingSlip;
use Illuminate\Database\Eloquent\Factories\Factory;

class SitePackingSlipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SitePackingSlip::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'site_id' => Site::firstOrFactory(),
            'packingslip_appendix_elementid' => Element::firstOrFactory(),
            'packingslip_showlogo' => $this->faker->boolean
        ];
    }
}
