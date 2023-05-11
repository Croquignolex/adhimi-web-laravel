<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use App\Enums\LanguageEnum;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Default morph key
        Builder::defaultMorphKeyType('uuid');

        // Morph names mapping
        Relation::enforceMorphMap([
            'user' => User::class,
            'payment' => Payment::class,
            'invoice' => Invoice::class,
        ]);

        // Custom blade directives
        Blade::directive('datetime', function (Carbon $date) {
            $output = match (App::getLocale()) {
                LanguageEnum::Fr->value => $date->format('Y-m-d H:i'),
                LanguageEnum::En->value => $date->format('d-m-Y H:i A'),
            };
            return "<?php echo $output; ?>";
        });
        Blade::directive('date', function (Carbon $date) {
            $output = match (App::getLocale()) {
                LanguageEnum::Fr->value => $date->format('Y-m-d'),
                LanguageEnum::En->value => $date->format('d-m-Y'),
            };
            return "<?php echo $output; ?>";
        });
        Blade::directive('time', function (Carbon $date) {
            $output = match (App::getLocale()) {
                LanguageEnum::Fr->value => $date->format('H:i'),
                LanguageEnum::En->value => $date->format('H:i A'),
            };
            return "<?php echo $output; ?>";
        });
        Blade::directive('active_page', function (string $route) {
            $output = (Route::is($route))
                ? 'active'
                : '';
            return "<?php echo $output; ?>";
        });
        Blade::directive('text_format', function (string $text, int $maxCharacters) {
            $output =(strlen($text) > $maxCharacters)
                ? mb_substr($text, 0, $maxCharacters, 'utf-8') . '...'
                : $text;
            return "<?php echo $output; ?>";
        });
    }
}
