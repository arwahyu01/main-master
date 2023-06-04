<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AccessGroupSeeder extends Seeder
{
    public function run()
    {
        $data =[
            [
                'id'=> 1,
                'name' => 'Root User',
                'code'=>'root',
            ],
            [
                'id'=> 2,
                'name' => 'Administrator',
                'code'=>'admin',
            ],
            [
                'id'=> 3,
                'name' => 'User',
                'code'=>'user',
            ],
        ];

        foreach ($data as $item) {
            \App\Models\AccessGroup::create($item);
        }
    }
}
