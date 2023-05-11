<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\LanguageEnum;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();

            $table->string('language')->default(LanguageEnum::Fr->value);
            $table->string('timezone')->default('UTC');

            $table->boolean('enable_action_on_super_admin_notification')->default(false);
            $table->boolean('enable_action_on_admin_notification')->default(false);
            $table->boolean('enable_action_on_manager_notification')->default(false);
            $table->boolean('enable_action_on_merchant_notification')->default(false);
            $table->boolean('enable_action_on_saler_notification')->default(false);
            $table->boolean('enable_action_on_user_notification')->default(false);

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
