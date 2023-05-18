<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\MigrationTrait;
use App\Models\Product;

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
        Schema::create('inventory_histories', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, nullable: true, foreignKey: 'creator_id');
            $this->addForeignKey(table: $table, nullable: true, foreignKey: 'organisation_id');
            $this->addForeignKey(table: $table, nullable: true, foreignKey: 'shop_id');
            $this->addForeignKey(table: $table, foreignModelFqn: Product::class);

            $table->morphs('stockable');

            $table->integer('quantity')->default(0);
            $table->integer('old_quantity')->default(0);
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
        Schema::dropIfExists('inventory_histories');
    }
};
