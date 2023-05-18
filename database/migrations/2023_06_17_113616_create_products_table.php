<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GeneralStatusEnum;
use App\Traits\MigrationTrait;
use App\Models\Organisation;
use App\Models\Category;
use App\Models\Country;
use App\Models\Brand;

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
        Schema::create('products', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, nullable:true, foreignKey: 'shop_id');
            $this->addForeignKey(table: $table, nullable:true, foreignKey: 'vendor_id');
            $this->addForeignKey(table: $table, foreignKey: 'creator_id', foreignTable: 'users');
            $this->addForeignKey(table: $table, foreignModelFqn: Category::class);
            $this->addForeignKey(table: $table, foreignModelFqn: Brand::class);
            $this->addForeignKey(table: $table, foreignModelFqn: Organisation::class);
            $this->addForeignKey(table: $table, foreignModelFqn: Country::class);

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->unique()->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('alert_quantity')->default(0);
            $table->integer('delivery_price')->default(0);
            $table->integer('purchase_price')->default(0);
            $table->integer('sale_price')->default(0);
            $table->integer('promotion_price')->default(0);
            $table->dateTime('promotion_started_at')->nullable();
            $table->dateTime('promotion_ended_at')->nullable();
            $table->string('status')->default(GeneralStatusEnum::StandBy->value);
            $table->text('description')->nullable();

            $this->addSeoFields($table);
            $this->addShippingFields($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
