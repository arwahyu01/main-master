<?php

namespace Database\Seeders;

use App\Models\AccessMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $data=[
            [
                'id'=>Str::uuid(),
                'parent_id'=>NULL,
                'title'=>'Dashboard',
                'subtitle'=>'Dashboard',
                'code'=>'dashboard',
                'url'=>'dashboard',
                'model'=>NULL,
                'icon'=>'fa fa-tachometer',
                'type'=>'backend',
                'show'=>true,
                'active'=>true,
                'sort'=>0,
            ],
            [
                'id'=>Str::uuid(),
                'parent_id'=>NULL,
                'title'=>'Master',
                'subtitle'=>'Master',
                'code'=>'master',
                'url'=>'master',
                'model'=>NULL,
                'icon'=>'fa fa-cogs',
                'type'=>'backend',
                'show'=>true,
                'active'=>true,
                'sort'=>1,
                'children'=>[
                    [
                        'id'=>Str::uuid(),
                        'parent_id'=>NULL,
                        'title'=>'Menu',
                        'subtitle'=>'Menu',
                        'code'=>'menu',
                        'url'=>'menu',
                        'model'=>'Menu',
                        'icon'=>'fa fa-bars',
                        'type'=>'backend',
                        'show'=>true,
                        'active'=>true,
                        'sort'=>0,
                    ],
                    [
                        'id'=>Str::uuid(),
                        'parent_id'=>NULL,
                        'title'=>'Level',
                        'subtitle'=>'Level',
                        'code'=>'level',
                        'url'=>'level',
                        'model'=>'Level',
                        'icon'=>'fa fa-user',
                        'type'=>'backend',
                        'show'=>true,
                        'active'=>true,
                        'sort'=>1,
                    ],
                    [
                        'id'=>Str::uuid(),
                        'parent_id'=>NULL,
                        'title'=>'Access Group',
                        'subtitle'=>'Access Group',
                        'code'=>'access-group',
                        'url'=>'access-group',
                        'model'=>'AccessGroup',
                        'icon'=>'fa fa-shield',
                        'type'=>'backend',
                        'show'=>true,
                        'active'=>true,
                        'sort'=>2,
                    ],
                    [
                        'id'=>Str::uuid(),
                        'parent_id'=>NULL,
                        'title'=>'Access Menu',
                        'subtitle'=>'Access Menu',
                        'code'=>'access-menu',
                        'url'=>'access-menu',
                        'model'=>'AccessMenu',
                        'icon'=>'fa fa-address-card',
                        'type'=>'backend',
                        'show'=>true,
                        'active'=>true,
                        'sort'=>3,
                    ],
                    [
                        'id'=>Str::uuid(),
                        'parent_id'=>NULL,
                        'title'=>'Faq',
                        'subtitle'=>'Frequently Asked Questions',
                        'code'=>'faq',
                        'url'=>'faq',
                        'model'=>'Faq',
                        'icon'=>'fa fa-question-circle',
                        'type'=>'backend',
                        'show'=>true,
                        'active'=>true,
                        'sort'=>4,
                    ]
                ]
            ],
            [
                'id'    =>Str::uuid(),
                'parent_id'=>NULL,
                'title'=>'User',
                'subtitle'=>'User',
                'code'=>'user',
                'url'=>'user',
                'model'=>'User',
                'icon'=>'fa fa-users',
                'type'=>'backend',
                'show'=>TRUE,
                'active'=>TRUE,
                'sort'=>2
            ],
            [
                'id'    =>Str::uuid(),
                'parent_id'=>NULL,
                'title'=>'Question',
                'subtitle'=>'Frequently Asked Questions',
                'code'=>'question',
                'url'=>'question',
                'model'=>'Faq',
                'icon'=>'fa fa-question-circle-o',
                'type'=>'backend',
                'show'=>FALSE,
                'active'=>TRUE,
                'sort'=>3
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\AccessMenu::truncate();
        \App\Models\Menu::truncate();
        foreach ($data as $item) {
            if($menu =\App\Models\Menu::updateOrCreate(['code'=>$item['code']],collect($item)->except('children')->toArray())){
                if(isset($item['children'])){
                    foreach ($item['children'] as $child) {
                        $child['parent_id']=$menu->id;
                        \App\Models\Menu::updateOrCreate(['code'=>$child['code']],$child);
                    }
                }
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
