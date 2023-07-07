<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['status','data','user_id'];
    protected $casts = ['id'=>'string','data'=>'array','status'=>'boolean','link'=>'string'];
    protected $appends = ['title','content','icon','link','color'];
    protected $hidden = ['data','notifiable_type','notifiable_id','created_at','updated_at','deleted_at'];

	public function notifiable() : object
	{
		return $this->morphTo();
	}

	public function user() : object
	{
		return $this->belongsTo(User::class);
	}

    public function scopeFilterByUser($query) : object
    {
        return $query->where('user_id', Auth::id());
    }

    public function setDataAttribute($value) : void
    {
        $this->attributes['data'] = json_encode($value);
    }

    public function getContentAttribute() : string
    {
        return $this->data['content'] ?? '';
    }

    public function getTitleAttribute() : string
    {
        return $this->data['title'] ?? 'No Title';
    }

    public function getIconAttribute() : string
    {
        return $this->data['icon'] ?? 'fa fa-bell';
    }

    public function getLinkAttribute() : string
    {
        return (!in_array($this->data['link'] ?? [], ['', 'null', null, '-', false, '#'])) ? $this->data['link'] : '#';
    }

    public function getColorAttribute() : string
    {
        return $this->data['color'] ?? 'text-primary';
    }

    public function getCreatedAtAttribute($value) : string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value) : string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function scopeUnread($query) : object
    {
        return $query->where('status', 0);
    }

    public function fetchNotification() : array
    {
        $data['notifications'] = $this->filterByUser()->unread()->orderBy('created_at', 'desc')->paginate(10);
        return $data;
    }

    public function markAsRead($user_id) : void
    {
        $this->where('user_id', $user_id)->update(['status' => 1]);
    }

    public function sendToMany(array $users, array $data)
    {
        $this->createMany($users, $data);
    }

    public function sendToOne($user, array $data) : void
    {
        $this->create($user, $data);
    }
}
