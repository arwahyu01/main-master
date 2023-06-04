<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AccessMenuSeeder extends Seeder
{
    public function run()
    {
        $groups = \App\Models\AccessGroup::all();
        \App\Models\AccessMenu::truncate();
        foreach ($groups as $group) {
            $menus = config('accessmenu.access.'.$group->code);
            foreach ($menus as $menu) {
                if($menu = \App\Models\Menu::where('code', $menu)->first()){
                    \App\Models\AccessMenu::create([
                        'access_group_id' => $group->id,
                        'menu_id' => $menu->id,
                        'access' => ['create', 'read', 'update', 'delete'],
                    ]);
                }
            }
        }
    }
}
