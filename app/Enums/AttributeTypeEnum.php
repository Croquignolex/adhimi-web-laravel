<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum AttributeTypeEnum: string
{
    use EnumToolsTrait;

    case Text = 'Text';
    case Select = 'Select';
    case Color = 'Color';
}
