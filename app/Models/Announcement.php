<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $casts = [
        'id' => 'string',
        'menu_id' => 'string',
        'parent_id' => 'string',
        'publish' => 'boolean',
    ];

    protected $fillable = ['id','menu_id','title','start','end','content','urgency','publish','parent_id'];
	public function menu() : object
	{
		return $this->belongsTo(Menu::class);
	}
	public function parent() : object
	{
		return $this->belongsTo($this, 'parent_id');
	}
    public function children() : object
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function getLinkAttribute() : string
    {
        return url(config('master.app.url.backend')."/announcement-detail/{$this->id}/".Str::slug(Str::replace('/', '-', $this->title)));
    }

    public function getDaysLeftAttribute() : int
    {
        return Carbon::createFromDate($this->end)->diffInDays();
    }

    public function file() : object
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function notification() : object
    {
        return $this->morphOne(Notification::class, 'notifiable');
    }
}
