<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable=[
        'id', 'parent_id', 'title', 'subtitle', 'code', 'url', 'model', 'icon', 'type', 'show', 'active', 'sort','maintenance','coming_soon'
    ];
    protected $casts=[
        'show'=>'boolean', 'active'=>'boolean', 'id'=>'string','parent_id'=>'string',
    ];
    protected $hidden=[
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function parent() : object
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children() : object
    {
        return $this->hasMany(Menu::class, 'parent_id')->sort();
    }

    public function announcement() : object
    {
        return $this->hasMany(Announcement::class, 'menu_id')->whereDate('end', '>=', date('Y-m-d'))->orderBy('start', 'desc');
    }

    public function accessChildren() : object
    {
        return $this->hasMany(Menu::class, 'parent_id')->with(['accessChildren'])->whereHas('access_menu', function ($query) {
                $query->where('access_group_id', auth()->user()->access_group_id);
            })->show()->active()->sort();
    }

    public function scopeSort($query) : object
    {
        return $query->orderBy('sort', 'asc');
    }

    public function scopeActive($query) : object
    {
        return $query->where('active', TRUE);
    }

    public function scopeShow($query) : object
    {
        return $query->where('show', TRUE);
    }

    public function access_menu() : object
    {
        return $this->hasMany(AccessMenu::class);
    }

    public function getModelAttribute() : string
    {
        return Str::replace('/','\\',config('master.app.root.model')).'\\'.$this->attributes['model'];
    }
}
