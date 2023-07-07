<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts=[
        'access'=>'array',
    ];
    protected $fillable=[
        'name', 'access', 'code',
    ];

    public function canAccess($level) : bool
    {
        return $this->access[$level] ?? false;
    }

    public static function makeLevelArray($request) : array
    {
        $levels=[];
        foreach (collect(config('master.app.level')) as $level) {
            $levels[$level]=collect($request->access)->contains($level);
        }
        return $levels;
    }

    public function scopeFilterLevel($query) : object
    {
        $level = auth()->user()->level->code;
        if($level != 'root'){
            $query->whereNotIn('code', ['root']);
        }
        return $query;
    }
}
