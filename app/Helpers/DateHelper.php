<?php

use Illuminate\Support\Facades\App;
use App\Enums\LanguageEnum;
use Carbon\Carbon;

if(!function_exists('format_datetime'))
{
    /**
     * @param Carbon $date
     * @return string
     */
    function format_datetime(Carbon $date): string
    {
        return match (App::getLocale()) {
            LanguageEnum::English->value => $date->format('d-m-Y H:i A'),
            default => $date->format('Y-m-d H:i')
        };
    }
}

if(!function_exists('format_date'))
{
    /**
     * @param Carbon $date
     * @return string
     */
    function format_date(Carbon $date): string
    {
        return match (App::getLocale()) {
            LanguageEnum::English->value => $date->format('d-m-Y'),
            default => $date->format('Y-m-d')
        };
    }
}

if(!function_exists('format_time'))
{
    /**
     * @param Carbon $date
     * @return string
     */
    function format_time(Carbon $date): string
    {
        return match (App::getLocale()) {
            LanguageEnum::English->value => $date->format('H:i A'),
            default => $date->format('H:i')
        };
    }
}