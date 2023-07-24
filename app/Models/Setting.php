<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Enums\LanguageEnum;

class Setting extends Model
{
    use HasFactory, SoftDeletes, BelongsToUserTrait, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'language',
        'timezone',

        'enable_action_on_super_admin_notification',
        'enable_action_on_admin_notification',
        'enable_action_on_manager_notification',
        'enable_action_on_merchant_notification',
        'enable_action_on_saler_notification',
        'enable_action_on_customer_notification',

        'enable_product_notification',
        'enable_purchase_notification',
        'enable_payment_notification',

        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'language' => LanguageEnum::class,

        'enable_action_on_super_admin_notification' => 'boolean',
        'enable_action_on_admin_notification' => 'boolean',
        'enable_action_on_manager_notification' => 'boolean',
        'enable_action_on_merchant_notification' => 'boolean',
        'enable_action_on_saler_notification' => 'boolean',
        'enable_action_on_customer_notification' => 'boolean',

        'enable_payment_notification' => 'boolean',
        'enable_purchase_notification' => 'boolean',
        'enable_product_notification' => 'boolean',
    ];

    /**
     * Scope a query to only include allowed model.
     */
    public function scopeAllowed(Builder $query): void
    {

    }
}
