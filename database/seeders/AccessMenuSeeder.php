<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AccessMenuSeeder extends Seeder
{
    public function run()
    {
        $group = json_decode(File::get(config_path('seeders/access-group.json')), true);
        foreach ($group as $item) {
            foreach ($item as $code => $menus) {
                if($accessGroup = \App\Models\AccessGroup::where('code', $code)->first()){
                    collect($menus)->map(function ($item) use ($accessGroup) {
                        if ($menu=\App\Models\Menu::where('code', $item)->first()) {
                            $accessGroup->access_menu()->updateOrCreate(['menu_id'=>$menu->id], [
                                'access_group_id'=>$accessGroup->id, 'access'=>[
                                    "read", "create", "update", "delete",
                                ],
                            ]);
                        }
                    });
                }
            }
        }
    }
}
