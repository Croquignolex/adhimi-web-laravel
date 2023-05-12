<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\MediaTypeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('creator_id')->constrained('users')->cascadeOnDelete();

            $table->nullableMorphs('mediatable');

            $table->string('type')->default(MediaTypeEnum::Image->value);
            $table->string('name');
            $table->string('url');
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
        Schema::dropIfExists('medias');
    }
};
