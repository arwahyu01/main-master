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

    public function loggable()
    {
        return $this->morphTo();
    }

    public function getDateAttribute()
    {
        return date('d-m-Y', strtotime($this->created_at));
    }

    public function getTimeAttribute()
    {
        return date('H:i:s', strtotime($this->created_at));
    }

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
}
