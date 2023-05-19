<?php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;
use App\Enums\DistanceValueEnum;
use App\Enums\QuantityValueEnum;
use App\Enums\WeightValueEnum;

trait MigrationTrait
{
    /**
     * @param Blueprint $table
     * @param bool $hasSoftDelete
     * @return void
     */
    public function addCommonFields(Blueprint $table, bool $hasSoftDelete = true): void
    {
        $table->uuid('id')->primary();

        $table->timestamps();

        if ($hasSoftDelete) {
            $table->softDeletes();
        }
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    public function addSeoFields(Blueprint $table): void
    {
        $table->string('seo_title')->nullable();
        $table->string('seo_description')->nullable();
    }

    /**
     * @param Blueprint $table
     * @return void
     */
    public function addShippingFields(Blueprint $table): void
    {
        $table->decimal('weight_value', 10, 5)
            ->nullable()
            ->default(0.00)
            ->unsigned();
        $table->string('weight_unit')->default(WeightValueEnum::Gramme->value);
        $table->decimal('height_value', 10, 5)
            ->nullable()
            ->default(0.00)
            ->unsigned();
        $table->string('height_unit')->default(DistanceValueEnum::Meter->value);
        $table->decimal('width_value', 10, 5)
            ->nullable()
            ->default(0.00)
            ->unsigned();
        $table->string('width_unit')->default(DistanceValueEnum::Meter->value);
        $table->decimal('depth_value', 10, 5)
            ->nullable()
            ->default(0.00)
            ->unsigned();
        $table->string('depth_unit')->default(DistanceValueEnum::Meter->value);
        $table->decimal('volume_value', 10, 5)
            ->nullable()
            ->default(0.00)
            ->unsigned();
        $table->string('volume_unit')->default(QuantityValueEnum::Liter->value);
    }

    /**
     * @param Blueprint $table
     * @param string|null $foreignModelFqn
     * @param bool $nullable
     * @param string|null $foreignKey
     * @param string|null $foreignTable
     * @return void
     */
    public function addForeignKey(Blueprint $table, bool $nullable = false, ?string $foreignModelFqn = null, ?string $foreignKey = null, ?string $foreignTable = null): void
    {
        if($nullable) {
            $table->foreignUuid($foreignKey)->nullable();
        }
        else
        {
            if(is_null($foreignModelFqn)) {
                $table->foreignUuid($foreignKey)->constrained($foreignTable)->cascadeOnDelete();
            } else {
                $table->foreignIdFor($foreignModelFqn)->constrained()->cascadeOnDelete();
            }
        }
    }
}
