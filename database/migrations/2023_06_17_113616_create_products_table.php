<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GeneralStatusEnum;
use App\Models\Organisation;
use App\Models\Category;
use App\Models\Brand;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('vendor_id')->nullable();
            $table->foreignUuid('shop_id')->nullable();
            $table->foreignUuid('creator_id')->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Brand::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Organisation::class)->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->integer('quantity')->default(0);
            $table->integer('delivery_price')->default(0);
            $table->integer('price')->default(0);
            $table->integer('promotion_price')->default(0);
            $table->dateTime('promotion_started_at')->nullable();
            $table->dateTime('promotion_ended_at')->nullable();
            $table->string('status')->default(GeneralStatusEnum::StandBy->value);
            $table->text('description')->nullable();

            $table->softDeletes();

            $table->timestamps();
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
