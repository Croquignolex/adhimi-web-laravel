<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('views', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();

            $table->morphs('viewable');

            $table->unique(['user_id', 'viewable_type', 'viewable_id']);

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
        Schema::dropIfExists('views');
    }
};
