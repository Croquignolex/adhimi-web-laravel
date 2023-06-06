<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\MigrationTrait;
use App\Enums\LanguageEnum;
use App\Models\User;

return new class extends Migration
{
    use MigrationTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, foreignModelFqn: User::class);

            $table->string('language')->default(LanguageEnum::French->value);
            $table->string('timezone')->default('UTC');

            $table->boolean('enable_action_on_super_admin_notification')->default(false);
            $table->boolean('enable_action_on_admin_notification')->default(false);
            $table->boolean('enable_action_on_manager_notification')->default(false);
            $table->boolean('enable_action_on_merchant_notification')->default(false);
            $table->boolean('enable_action_on_saler_notification')->default(false);
            $table->boolean('enable_action_on_customer_notification')->default(false);

            $table->boolean('enable_product_notification')->default(false);
            $table->boolean('enable_purchase_notification')->default(false);
            $table->boolean('enable_payment_notification')->default(false);

            $table->unique(['id', 'user_id']);
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
