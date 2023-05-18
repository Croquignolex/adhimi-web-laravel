<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum MediaTypeEnum: string
{
    use EnumToolsTrait;

    case Image = 'Image';
    case Banner = 'Banner';
    case Logo = 'Logo';
    case Video = 'Video';
    case Txt = 'Txt';
    case PDF = 'PDF';
}
