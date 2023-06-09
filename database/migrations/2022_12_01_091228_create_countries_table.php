<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GeneralStatusEnum;
use App\Traits\MigrationTrait;

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
        Schema::create('countries', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, nullable: true, foreignKey: 'creator_id');

            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('phone_code')->nullable();
            $table->decimal('latitude', 10, 5)->nullable();
            $table->decimal('longitude', 10, 5)->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default(GeneralStatusEnum::Enable->value);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
