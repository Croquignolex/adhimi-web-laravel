<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GeneralStatusEnum;
use App\Traits\MigrationTrait;
use App\Models\Organisation;

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
        Schema::create('coupons', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, foreignKey: 'creator_id', foreignTable: 'users');
            $this->addForeignKey(table: $table, foreignModelFqn: Organisation::class);

            $table->string('code')->unique();
            $table->integer('discount');
            $table->unsignedInteger('total_use')->default(0);
            $table->dateTime('promotion_started_at')->nullable();
            $table->dateTime('promotion_ended_at')->nullable();
            $table->string('status')->default(GeneralStatusEnum::Enable->value);
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
        Schema::dropIfExists('coupons');
    }
};
