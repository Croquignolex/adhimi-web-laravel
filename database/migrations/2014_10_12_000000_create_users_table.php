<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserStatusEnum;
use App\Models\Organisation;
use App\Enums\GenderEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('creator_id')->nullable();
            $table->foreignUuid('shop_id')->nullable();
            $table->foreignUuid('organisation_id')->nullable();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('first_purchase')->default(false);
            $table->string('profession')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->default(GenderEnum::Unknown->value);
            $table->date('birthdate')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default(UserStatusEnum::Active->value);

            $table->unique(['organisation_id', 'name']);

            $table->softDeletes();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
