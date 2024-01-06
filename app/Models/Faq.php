<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Faq extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['id','title','menu_id','parent_id','description','visitors','like','dislike','publish'];

    protected $casts =[
        'publish' => 'boolean',
    ];

    public function menu() : object
    {
        return $this->belongsTo(Menu::class);
    }

	public function parent() : object
	{
		return $this->belongsTo(Faq::class, 'parent_id', 'id');
	}

    public function children() : object
    {
        return $this->hasMany(Faq::class, 'parent_id', 'id');
    }

    public function family() : object
    {
        return $this->hasMany(Faq::class, 'menu_id', 'menu_id');
    }

    public function file() : object
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function log() : object
    {
        return $this->morphOne(Log::class, 'loggable');
    }

    public function getFolderAttribute() : string
    {
        return Str::lower(Str::snake(class_basename($this), '-')).'/'.date('Y').'/'.date('m').'/'.date('d');
    }
}
