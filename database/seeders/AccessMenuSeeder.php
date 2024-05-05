<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AccessMenuSeeder extends Seeder
{
    public function run()
    {
        $groups=json_decode(File::get(database_path('seeders/backup/access-group.json')), true);
        $access_menu=json_decode(File::get(database_path('seeders/backup/access-menu.json')), true);
        foreach ($groups as $item) {
            $accessGroup=\App\Models\AccessGroup::where('code', $item['code'])->first();
            collect($item['menu'] ?? [])->map(function ($item) use ($accessGroup, $access_menu) {
                if ($menu=\App\Models\Menu::where('code', $item)->first()) {
                    $access=collect($access_menu)->where('code_menu', $item)->where('access_group_code', $accessGroup->code)->first();
                    $accessGroup->access_menu()->updateOrCreate(['menu_id'=>$menu->id], [
                        'access_group_id'=>$accessGroup->id, 'access'=>$access['access'] ?? null,
                    ]);
                }
            });
        }
    }
}
