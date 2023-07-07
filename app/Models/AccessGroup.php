<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class AccessGroup extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = ['id', 'name', 'code'];

    public function users(): object
    {
        return $this->hasMany(User::class);
    }

    public function access_menu(): object
    {
        return $this->hasMany(AccessMenu::class);
    }

    public function scopeCanAccess($query, $crud): bool
    {
        $route = collect(explode(".", Route::currentRouteName()))->first();
        if ($menu = Menu::where('code', $route)->first()) {
            return $query->whereHas('access_menu', function ($query) use ($menu, $crud) {
                $query->whereMenuId($menu->id)->whereAccessGroupId($this->id)->whereJsonContains('access', $crud);
            })->exists();
        }
        return false;
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
