<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GeneralStatusEnum;
use App\Traits\MigrationTrait;
use App\Models\Country;

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
        Schema::create('states', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, nullable: true, foreignKey: 'creator_id');
            $this->addForeignKey(table: $table, foreignModelFqn: Country::class);

            $table->string('name');
            $table->string('slug')->unique();
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
        Schema::dropIfExists('states');
    }
};
