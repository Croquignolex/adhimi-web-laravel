<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum AttributeTypeEnum: string
{
    use EnumToolsTrait;

    case Text = 'text';
    case Select = 'select';
    case Color = 'color';
}
