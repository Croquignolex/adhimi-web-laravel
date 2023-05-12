<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum MediaTypeEnum: string
{
    use EnumToolsTrait;

    case Image = 'image';
    case Banner = 'Banner';
    case Logo = 'Logo';
    case Video = 'video';
    case Txt = 'Txt';
    case PDF = 'PDF';
}
