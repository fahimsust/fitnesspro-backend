<?php

namespace Domain\Sites\Enums;

enum RequireLogin: string
{
    case None = 'none';
    case Site = 'site';
    case Catalog = 'catalog';
    case Checkout = 'checkout';

    public static function options(): array
    {
        return [
            [
                'id' => self::None,
                'name' => __('None'),
            ],
            [
                'id' => self::Site,
                'name' => __('Site'),
            ],
            [
                'id' => self::Catalog,
                'name' => __('Catalog'),
            ],
            [
                'id' => self::Checkout,
                'name' => __('Checkout'),
            ]
        ];
    }

    public function forSite(): bool
    {
        return $this === self::Site;
    }

    public function forCatalog(): bool
    {
        return in_array($this, [
            self::Catalog,
            self::Site
        ]);
    }

    public function forCheckout(): bool
    {
        return $this !== self::None;
    }
}
