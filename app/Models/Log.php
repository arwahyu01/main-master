<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $casts=[
        'id'=>'string', 'data'=>'array',
    ];

    protected $fillable=['alias', 'data', 'ip', 'user_agent'];

    public function loggable() : object
    {
        return $this->morphTo();
    }
}
