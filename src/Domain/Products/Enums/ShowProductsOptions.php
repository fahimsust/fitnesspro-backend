<?php

namespace Domain\Products\Enums;

enum ShowProductsOptions: int
{
    case DontShowProducts = -1;
    case UseCategorySettingFilters = 0;
    case UseManuallyRelatedProducts = 1;
    case UseBothFilteredAndManual = 2;

    public function dont(): bool
    {
        return $this == self::DontShowProducts;
    }

    public function useSettings(): bool
    {
        return $this == self::UseCategorySettingFilters;
    }

    public function useManual(): bool
    {
        return $this == self::UseManuallyRelatedProducts;
    }

    public function useBoth(): bool
    {
        return $this == self::UseBothFilteredAndManual;
    }
}
