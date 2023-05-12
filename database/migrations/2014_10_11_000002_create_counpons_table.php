<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GeneralStatusEnum;
use App\Models\Organisation;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('creator_id')->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Organisation::class)->constrained()->cascadeOnDelete();

            $table->string('code')->unique();
            $table->integer('discount');
            $table->dateTime('promotion_started_at')->nullable();
            $table->dateTime('promotion_ended_at')->nullable();
            $table->string('status')->default(GeneralStatusEnum::Enable);
            $table->text('description')->nullable();

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
        Schema::dropIfExists('coupons');
    }
};
