<?php

namespace App\support;

use App\Models\Menu;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function menu($code=null): ?object
    {
        return Menu::where('code', explode(".", $code ?? Route::currentRouteName())[0])->first();
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

    /**
     * Bytes Converter untuk mengubah ukuran bytes menjadi satuan yang lebih besar
     * @param $bytes
     * @return string
     */
    public static function bytesConverter($bytes) : string
    {
        $result = $bytes;
        $unit = 'B';
        if ($bytes > 1024) {
            $result = $bytes / 1024;
            $unit = 'KB';
        }
        if ($bytes > 1048576) {
            $result = $bytes / 1048576;
            $unit = 'MB';
        }
        if ($bytes > 1073741824) {
            $result = $bytes / 1073741824;
            $unit = 'GB';
        }
        if ($bytes > 1099511627776) {
            $result = $bytes / 1099511627776;
            $unit = 'TB';
        }
        return round($result, 2) . ' ' . $unit;
    }

    /**
     * @param $text string //text yang akan di sort
     * @param $length int
     * @return string
     */
    public static function sortText($text,$length=100): string
    {
        return substr($text, 0, $length) . (strlen($text) > $length ? '...' : '');
    }

    public static function yearBeforeAfter() : array
    {
        $yearNow = (int) date('Y');
        $data = [];
        for ($i = $yearNow - 1; $i <= $yearNow + 1;) {
            $data += [$i => "$i"];
            $i++;
        }
        return $data;
    }

    /**
     * Mengubah format mata uang menjadi angka biasa tanpa titik dan koma
     * @param $number
     * @param  string  $currency
     * @return string
     */
    public static function clearCurrencyFormat($number, string $currency='Rp') : string
    {
        return str_replace([$currency, '.', ','], '', $number);
    }

    /**
     * Mengubah format angka menjadi mata uang
     * @param $number
     * @param  string  $currency
     * @return string
     */
    public static function currency($number, string $currency='Rp') : string
    {
        return $currency.' '.number_format($number, 0, ',', '.');
    }

    /**
     * Untuk mengubah format angka menambahkan 0 di depannya
     * @param $number
     * @param  int $length
     * @return string
     */
    public static function formatNumberWithZero($number, int $length=5) : string
    {
        return str_pad($number, $length, '0', STR_PAD_LEFT);
    }

    /**
     * @param $model
     * @param $users
     * @param  array  $array
     * Send Notification to user
     * Example:
     * $this->help::sendNotification($announcement, $users, [
                'title' => 'Title Notification',
                'link' => $announcement->link,
                'icon' => 'fa fa-bullhorn',
                'color' => 'text-info',
                'content' => $announcement->title
            ]);
     * @return void
     */
    public static function sendNotification($model, $users, array $array)
    {
        $users = is_array($users) ? $users : [$users];
        $model->notification()->createMany(collect($users)->map(function ($item) use ($array) {
            return ['user_id' => $item, 'data' => $array,'status'=>0];
        })->toArray());
    }

    /**
     * Method ini digunakan memfilter string yang sama
     * @param  string  $text1 //String yang akan di filter
     * @param  string  $text2 //String pembanding
     * @return string
     */
    public static function diffString(string $text1, string $text2) : string
    {
        $string1=explode(' ', $text1);
        $string2=explode(' ', $text2);
        return implode(' ', array_diff($string1, $string2)).' '.$text2;
    }

    /**
     * Random string generator
     * @return string
     */
    public static function randomWord() : string
    {
        $words = json_decode(File::get(config_path('seeders/words.json')), true)['words'];
        return $words[rand(0, count($words) - 1)];
    }

    /**
     * Helper untuk mengupload gambar base64 ke storage yang berasal dari text editor
     * @param  string  $content //Content yang akan di convert menjadi gambar
     * @param  object  $model //Subject model yang akan di upload gambar
     * @return false|string
     */
    public static function uploadImageBase64(string $content, object $model)
    {
        $dom=new \DomDocument;
        libxml_use_internal_errors(true);
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images=$dom->getElementsByTagName('img');
        foreach ($images as $image) {
            $base64Data=$image->getAttribute('src');
            $img=explode(',', $base64Data, 2);
            if (count($img) === 2 && strpos($img[0], 'base64') !== false) {
                $imageData=base64_decode($img[1]);
                $imageName='generated_image_'.time().'_'.rand(1000, 9999).'.webp';
                $imagePath=$model->folder.'/'.$imageName;
                if (Storage::disk(config('filesystems.default'))->put($imagePath, $imageData)) {
                    $file=$model->file()->create([
                        'data'=>[
                            'disk'=>config('filesystems.default'),
                            'target'=>$model->folder.'/'.$imageName,
                        ],
                        'alias'=>'image_editor',
                    ]);
                    $image->setAttribute('src', $file->link_stream);
                    $image->setAttribute('alt', $file->name);
                    $image->setAttribute('id', $file->id);
                }
            }
        }
        $cleanedHtml=$dom->saveHTML();
        return $cleanedHtml;
    }
}
