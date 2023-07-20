<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GeneralStatusEnum;
use App\Traits\MigrationTrait;
use App\Models\Attribute;

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
        Schema::create('attribute_values', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, nullable:true, foreignKey: 'creator_id');
            $this->addForeignKey(table: $table, foreignModelFqn: Attribute::class);

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('value');
            $table->string('status')->default(GeneralStatusEnum::StandBy->value);
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
        Schema::dropIfExists('attribute_values');
    }
};
