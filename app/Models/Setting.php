<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUserTrait;

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
        'enable_action_on_user_notification',

        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enable_action_on_super_admin_notification' => 'boolean',
        'enable_action_on_admin_notification' => 'boolean',
        'enable_action_on_manager_notification' => 'boolean',
        'enable_action_on_merchant_notification' => 'boolean',
        'enable_action_on_saler_notification' => 'boolean',
        'enable_action_on_user_notification' => 'boolean',
    ];
}
