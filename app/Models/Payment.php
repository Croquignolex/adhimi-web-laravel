<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\MorphOneHardCopyTrait;
use App\Traits\Models\MorphManyLogsTrait;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentProviderEnum;
use App\Enums\PaymentStatusEnum;

class Payment extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
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
        'provider',
        'amount',
        'phone',
        'data',

        'invoice_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => PaymentStatusEnum::class,
        'data' => 'array',
        'provider' => PaymentProviderEnum::class,
    ];

    /**
     * Determine invoice status badge, magic attribute $this->status_badge.
     *
     * @return Attribute
     */
    protected function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn () => match ($this->status) {
                PaymentStatusEnum::Successful => [
                    'value' => PaymentStatusEnum::Successful->value,
                    'color' => 'success',
                ],
                PaymentStatusEnum::Canceled => [
                    'value' => PaymentStatusEnum::Canceled->value,
                    'color' => 'secondary',
                ],
                PaymentStatusEnum::Failed => [
                    'value' => PaymentStatusEnum::Failed->value,
                    'color' => 'danger',
                ],
            }
        );
    }

    /**
     * Determine invoice provider name, magic attribute $this->provider_name.
     *
     * @return Attribute
     */
    protected function providerName(): Attribute
    {
        return new Attribute(
            get: fn () => match ($this->provider) {
                PaymentProviderEnum::MTN => "MTN",
                PaymentProviderEnum::ORANGE => "ORANGE",
            }
        );
    }

    /**
     * Get the invoice that owns the current model.
     *
     * @return BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
