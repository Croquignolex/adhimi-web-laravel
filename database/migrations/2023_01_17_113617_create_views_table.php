<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\MigrationTrait;
use App\Models\User;

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
        Schema::create('views', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, foreignModelFqn: User::class);

            $table->morphs('viewable');

            $table->unique(['user_id', 'viewable_type', 'viewable_id']);
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
