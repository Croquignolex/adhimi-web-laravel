<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GeneralStatusEnum;
use App\Models\Attribute;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('creator_id')->nullable();
            $table->foreignIdFor(Attribute::class)->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('value');
            $table->string('status')->default(GeneralStatusEnum::StandBy->value);
            $table->text('description')->nullable();

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
        Schema::dropIfExists('attribute_values');
    }
};
