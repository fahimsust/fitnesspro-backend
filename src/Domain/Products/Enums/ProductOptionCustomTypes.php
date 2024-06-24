<?php

namespace Domain\Products\Enums;

enum ProductOptionCustomTypes: int
{
    case TEXT = 0;
    case TEXTAREA = 1;
    case COLORPICKER = 2;
}
