<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at', 'level_id', 'access_group_id',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'string',
    ];

    protected $primaryKey = 'id';

    public function level(): object
    {
        return $this->belongsTo(Level::class);
    }

    public function access_group(): object
    {
        return $this->belongsTo(AccessGroup::class);
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function tokens(): object
    {
        return $this->morphMany(Sanctum::$personalAccessTokenModel, 'tokenable', 'tokenable_type', 'tokenable_id');
    }

    public function getCreateAttribute(): bool
    {
        return $this->access_group->canAccess('create');
    }

    public function getReadAttribute(): bool
    {
        return $this->access_group->canAccess('read');
    }

    public function getUpdateAttribute(): bool
    {
        return $this->access_group->canAccess('update');
    }

    public function getDeleteAttribute(): bool
    {
        return $this->access_group->canAccess('delete');
    }
}
