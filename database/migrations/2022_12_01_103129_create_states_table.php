<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GeneralStatusEnum;
use App\Models\Country;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignIdFor(Country::class)->constrained()->cascadeOnDelete();
            $table->foreignUuid('creator_id')->nullable();

            $table->string('code');
            $table->string('name');
            $table->string('status')->default(GeneralStatusEnum::StandBy->value);

            $table->unique(['country_id', 'code', 'name']);

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
        Schema::dropIfExists('states');
    }
};
