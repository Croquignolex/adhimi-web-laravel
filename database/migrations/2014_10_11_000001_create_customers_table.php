<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\MigrationTrait;
use App\Enums\UserStatusEnum;
use App\Enums\GenderEnum;

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
        Schema::create('customers', function (Blueprint $table) {
            $this->addCommonFields($table);

            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('first_purchase')->default(false);
            $table->string('profession')->nullable();
            $table->string('gender')->default(GenderEnum::Unknown->value);
            $table->date('birthdate')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default(UserStatusEnum::Active->value);

            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
