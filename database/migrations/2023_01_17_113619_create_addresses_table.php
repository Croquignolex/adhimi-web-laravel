<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\AddressTypeEnum;
use App\Traits\MigrationTrait;
use App\Models\State;

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
        Schema::create('addresses', function (Blueprint $table) {
            $this->addCommonFields($table);

            $this->addForeignKey(table: $table, foreignKey: 'creator_id', foreignTable: 'users');
            $this->addForeignKey(table: $table, foreignModelFqn: State::class);

            $table->morphs('addressable');

            $table->string('type')->default(AddressTypeEnum::Default->value);
            $table->string('street_address');
            $table->string('street_address_plus')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('phone_number_one')->nullable();
            $table->string('phone_number_two')->nullable();
            $table->decimal('latitude', 10, 5)->nullable();
            $table->decimal('longitude', 10, 5)->nullable();
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
        Schema::dropIfExists('addresses');
    }
};
