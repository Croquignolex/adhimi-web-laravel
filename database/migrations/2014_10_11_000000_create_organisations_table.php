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
        Schema::create('organisations', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, nullable: true, foreignKey: 'creator_id');

            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->default(GeneralStatusEnum::Enable->value);
            $table->text('description')->nullable();

            $this->addSeoFields($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
