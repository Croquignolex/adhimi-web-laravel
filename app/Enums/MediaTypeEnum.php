<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum MediaTypeEnum: string
{
    use EnumToolsTrait;

    case Image = 'images';
    case Avatar = 'avatars';
    case Banner = 'banners';
    case Logo = 'logos';
    case Video = 'videos';
    case Document = 'documents';
}
