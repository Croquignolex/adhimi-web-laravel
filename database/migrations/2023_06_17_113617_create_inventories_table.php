<?php

use App\Models\Organisation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\InventoryConditionEnum;
use App\Enums\GeneralStatusEnum;
use App\Traits\MigrationTrait;
use App\Models\Country;
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
        Schema::create('inventories', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, nullable:true, foreignKey: 'vendor_id');
            $this->addForeignKey(table: $table, foreignKey: 'creator_id', foreignTable: 'users');
            $this->addForeignKey(table: $table, foreignModelFqn: Organisation::class);
            $this->addForeignKey(table: $table, foreignModelFqn: Country::class);
            $this->addForeignKey(table: $table, foreignModelFqn: Product::class);

            $table->string('condition')->default(InventoryConditionEnum::New->value);
            $table->integer('quantity')->default(0);
            $table->integer('alert_quantity')->default(0);
            $table->integer('delivery_price')->default(0);
            $table->integer('purchase_price')->default(0);
            $table->integer('sale_price')->default(0);
            $table->integer('promotion_price')->default(0);
            $table->timestamp('promotion_started_at')->nullable();
            $table->timestamp('promotion_ended_at')->nullable();
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
        Schema::dropIfExists('inventories');
    }
};
