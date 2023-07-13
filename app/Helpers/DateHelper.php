<?php

use Illuminate\Support\Facades\Auth;
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
        $date = timezone_date($date);

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
        $date = timezone_date($date);

        return match (App::getLocale()) {
            LanguageEnum::French->value => $date->format('d-m-Y'),
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
        $date = timezone_date($date);

        return match (App::getLocale()) {
            LanguageEnum::English->value => $date->format('H:i A'),
            default => $date->format('H:i')
        };
    }
}

if(!function_exists('timezone_date'))
{
    /**
     * @param Carbon $date
     * @return Carbon
     */
    function timezone_date(Carbon $date): Carbon
    {
        $timezone = Auth::user()->setting->timezone;
        return $date->timezone($timezone);
    }
}