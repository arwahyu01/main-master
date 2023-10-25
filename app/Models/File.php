<?php

namespace App\Models;

use App\support\Helper;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $casts=[
        'id'=>'string', 'data'=>'array',
    ];

    protected $fillable=['alias', 'data'];

    protected $appends =[
      'link_stream','link_download','link_delete'
    ];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function getFileNameAttribute() : string
    {
        return $this->data['name'] ?? $this->target;
    }

    public function getNameAttribute() : string
    {
        return Arr::last(Str::of($this->file_name)->explode('/')->toArray());
    }

    public function getNameAliasAttribute() : string
    {
        return Str::slug(preg_replace('/\\.[^.\\s]{3,4}$/', '-', $this->name));
    }

    public function getTargetAttribute() : string
    {
        return $this->data['target'];
    }

    public function getDiskAttribute() : string
    {
        return $this->data['disk'] ?? config('filesystems.default');
    }

    public function getPathAttribute() : string
    {
        return Str::of($this->target)->explode('/')->slice(0, -1)->implode('/');
    }

    public function getTakeAttribute() : string
    {
        return Storage::disk($this->disk)->get($this->target);
    }

    public function getExtensionAttribute() : string
    {
        return Str::of($this->file_name)->explode('.')->last();
    }

    public function getSizeAttribute() : string
    {
        return Helper::bytesConverter(Storage::disk($this->disk)->size($this->target));
    }

    public function getTypeAttribute() : string
    {
        $file=Storage::disk($this->disk)->mimeType($this->target);
        $image=['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
        $video=['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv', 'video/x-flv', 'video/x-matroska', 'video/3gpp', 'video/3gpp2', 'video/x-m4v', 'video/quicktime'];
        $audio=['audio/mpeg', 'audio/x-wav', 'audio/ogg', 'audio/x-m4a', 'audio/x-matroska'];
        return in_array($file, $image) ? 'image' : (in_array($file, $video) ? 'video' : (in_array($file, $audio) ? 'audio' : 'file'));
    }

    public function getMimeAttribute() : string
    {
        return Storage::disk($this->disk)->mimeType($this->target);
    }

    public function getModelNameAttribute() : string
    {
        return Str::of(class_basename($this->fileable_type))->snake()->plural();
    }

    public function getLinkStreamAttribute() : string
    {
        return url(config('master.app.url.backend')."/file/stream/{$this->id}/{$this->name_alias}-".uniqid());
    }

    public function getLinkDownloadAttribute() : string
    {
        return url(config('master.app.url.backend')."/file/download/{$this->id}/{$this->name_alias}-".uniqid());
    }

    public function getLinkDeleteAttribute() : string
    {
        return url(config('master.app.url.backend')."/file/delete/{$this->id}/{$this->name_alias}-".uniqid());
    }

    public function getExistsAttribute() : bool
    {
        return Storage::disk($this->disk)->exists($this->target);
    }

    protected static function booted()
    {
        static::forceDeleting(function ($file) {
            Storage::disk($file->disk)->delete($file->target);
        });
    }
}
