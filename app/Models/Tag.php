<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\TimezoneDateTrait;
use Illuminate\Database\Eloquent\Model;
use App\Enums\GeneralStatusEnum;

class Tag extends Model
{
    use HasFactory, BelongsToCreatorTrait, HasUuids, TimezoneDateTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',

        'creator_id',
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
     * Get all invoices that are assigned this tag.
     *
     * @return MorphToMany
     */
    public function invoices(): MorphToMany
    {
        return $this->morphedByMany(Invoice::class, 'taggable');
    }

    /**
     * Get all payments that are assigned this tag.
     *
     * @return MorphToMany
     */
    public function payments(): MorphToMany
    {
        return $this->morphedByMany(Payment::class, 'taggable');
    }

    /**
     * Get all groups that are assigned this tag.
     *
     * @return MorphToMany
     */
    public function groups(): MorphToMany
    {
        return $this->morphedByMany(Group::class, 'taggable');
    }
}
