<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\MigrationTrait;
use App\Enums\MediaTypeEnum;

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
        Schema::create('medias', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, foreignKey: 'creator_id', foreignTable: 'users');

            $table->nullableMorphs('mediatable');

            $table->string('type')->default(MediaTypeEnum::Image->value);
            $table->string('name');
            $table->string('location')->nullable();
            $table->boolean('is_local')->default(true);
            $table->text('description')->nullable();
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
