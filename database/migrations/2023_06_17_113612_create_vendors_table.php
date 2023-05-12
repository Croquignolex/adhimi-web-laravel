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
        Schema::create('vendors', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('creator_id')->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Organisation::class)->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default(GeneralStatusEnum::StandBy->value);

            $table->unique(['organisation_id', 'name']);

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
        Schema::dropIfExists('vendors');
    }
};
