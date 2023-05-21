<?php

use Illuminate\Support\Facades\App;
use App\Enums\LanguageEnum;
use Carbon\Carbon;

if(!function_exists('datetime_format'))
{
    /**
     * @param Carbon $date
     * @return string
     */
    function datetime_format(Carbon $date): string
    {
        return match (App::getLocale()) {
            LanguageEnum::English->value => $date->format('d-m-Y H:i A'),
            default => $date->format('Y-m-d H:i')
        };
    }
}

if(!function_exists('date_format'))
{
    /**
     * @param Carbon $date
     * @return string
     */
    function date_format(Carbon $date): string
    {
        return match (App::getLocale()) {
            LanguageEnum::English->value => $date->format('d-m-Y'),
            default => $date->format('Y-m-d')
        };
    }
}

if(!function_exists('time_format'))
{
    /**
     * @param Carbon $date
     * @return string
     */
    function time_format(Carbon $date): string
    {
        return match (App::getLocale()) {
            LanguageEnum::English->value => $date->format('H:i A'),
            default => $date->format('H:i')
        };
    }
}