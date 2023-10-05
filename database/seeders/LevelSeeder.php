<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $access_menu=json_decode(File::get(config_path('seeders/level.json')), true);
        foreach ($access_menu as $item) {
            \App\Models\Level::updateOrCreate(['code'=>$item['code']], [
                'name'=>$item['name'],
                'access'=>$item['access'],
            ]);
        }
    }
}
