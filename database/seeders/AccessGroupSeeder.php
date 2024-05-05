<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AccessGroupSeeder extends Seeder
{
    public function run()
    {
        $groups=json_decode(File::get(database_path('seeders/backup/access-group.json')), true);
        foreach ($groups as $item) {
            \App\Models\AccessGroup::updateOrCreate(['id'=>$item['id'],'code'=>$item['code']], ['name'=>$item['name']]);
        }
    }
}
