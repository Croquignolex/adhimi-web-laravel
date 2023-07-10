<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\MorphOneDefaultAddressTrait;
use App\Traits\Models\BelongsToOrganisationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\HasManyProductsTrait;
use App\Traits\Models\MorphManyLogsTrait;
use App\Traits\Models\NameInitialsTrait;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\MorphOneLogoTrait;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\SearchScopeTrait;
use App\Traits\Models\StatusBadgeTrait;
use App\Traits\Models\UniqueSlugTrait;
use App\Enums\GeneralStatusEnum;

class Vendor extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        UniqueSlugTrait,
        EnableScopeTrait,
        SearchScopeTrait,
        StatusBadgeTrait,
        MorphOneLogoTrait,
        SlugFromNameTrait,
        NameInitialsTrait,
        MorphManyLogsTrait,
        HasManyProductsTrait,
        BelongsToCreatorTrait,
        BelongsToOrganisationTrait,
        MorphOneDefaultAddressTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'status',
        'description',

        'creator_id',
        'organisation_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => GeneralStatusEnum::class,
    ];

    /**
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['name'];

    /**
     * Determine country entity, magic attribute $this->entity.
     *
     * @return Attribute
     */
    protected function entity(): Attribute
    {
        $this->load('logo');

        return new Attribute(
            get: fn () => [
                'url' => route('admin.vendors.show', [$this]),
                'image' => $this->logo?->url,
                'label' => $this->name,
                'has_image' => true,
            ]
        );
    }
}
