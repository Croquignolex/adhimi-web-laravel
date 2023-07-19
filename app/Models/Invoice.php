<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\MorphOneHardCopyTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\BelongsToUserTrait;
use App\Traits\Models\MorphManyLogsTrait;
use Illuminate\Database\Eloquent\Model;
use App\Enums\InvoiceStatusEnum;

class Invoice extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        BelongsToUserTrait,
        MorphManyLogsTrait,
        MorphOneHardCopyTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference',
        'status',
        'amount',

        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => InvoiceStatusEnum::class
    ];

    /**
     * Scope a query to only include allowed model.
     */
    public function scopeAllow(Builder $query): void
    {

    }

    /**
     * Determine if invoice is paid, magic attribute $this->is_paid.
     *
     * @return Attribute
     */
    protected function isPaid(): Attribute
    {
        return new Attribute(
            get: fn () => enums_equals($this->status, InvoiceStatusEnum::Paid)
        );
    }

    /**
     * Determine invoice status badge, magic attribute $this->status_badge.
     *
     * @return Attribute
     */
    protected function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn () => match ($this->status) {
                InvoiceStatusEnum::Paid => [
                    'value' => InvoiceStatusEnum::Paid->value,
                    'color' => 'success',
                ],
                InvoiceStatusEnum::Pending => [
                    'value' => InvoiceStatusEnum::Pending->value,
                    'color' => 'warning',
                ],
                InvoiceStatusEnum::Canceled => [
                    'value' => InvoiceStatusEnum::Canceled->value,
                    'color' => 'danger',
                ],
            }
        );
    }

    /**
     * Get payments associated with the invoice.
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
