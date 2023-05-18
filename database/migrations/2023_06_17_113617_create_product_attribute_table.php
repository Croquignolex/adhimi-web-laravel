<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\MigrationTrait;
use App\Models\AttributeValue;
use App\Models\Attribute;
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
        Schema::create('product_attribute', function (Blueprint $table) {
            $this->addForeignKey(table: $table, foreignModelFqn: Product::class);
            $this->addForeignKey(table: $table, foreignModelFqn: Attribute::class);
            $this->addForeignKey(table: $table, foreignModelFqn: AttributeValue::class);

            $table->unique(['product_id', 'attribute_id', 'attribute_value_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute');
    }
};
