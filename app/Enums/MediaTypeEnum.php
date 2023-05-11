<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum MediaTypeEnum: string
{
    use EnumToolsTrait;

    case Image = 'image';
    case Video = 'video';
    case File = 'file';
    case TBD = 'TBD';
}
