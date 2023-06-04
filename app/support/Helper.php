<?php

namespace App\support;

use App\Models\Menu;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class Helper
{
    public static function menu(): ?array
    {
        if ($menu=Menu::whereCode(explode(".", Route::currentRouteName())[0])->first()) {
            $data=[
                'code'=>$menu->code ?? NULL,
                'model'=>$menu->model ?? NULL,
                'url'=>$menu->url ?? NULL,
            ];
        }
        return $data ?? NULL;
    }

    /**
     * @param $extension array //type file yang akan ditampilkan
     * @return array
     */
    public static function listFile($path, $extension): array
    {
        $model=[];
        foreach (File::files($path) as $files) {
            if (in_array($files->getExtension(), $extension)) {
                foreach ($extension as $ext) {
                    $name=Arr::first(explode('.', $files->getFilename()));
                    $model[$name]=$name;
                }
            }
        }
        return $model;
    }

    public static function bytesConverter($bytes): string
    {
        $bytes=(int)$bytes;
        $units=['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes=max($bytes, 0);
        return round($bytes / pow(1024, ($i=floor(log($bytes, 1024)))), 2) . ' ' . $units[$i];
    }

    public static function sortText($text,$length=100): string
    {
        return substr($text, 0, $length) . (strlen($text) > $length ? '...' : '');
    }
}
