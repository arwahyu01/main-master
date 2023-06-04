<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'=> 1,
                'name' => 'Root User',
                'code'=>'root',
                'access' => [
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => true,
                ],
            ],
            [
                'id'=> 2,
                'name' => 'Administrator',
                'code'=>'admin',
                'access' => [
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => true,
                ],
            ],
            [
                'id'=> 3,
                'name' => 'User',
                'code'=>'user',
                'access' => [
                    'create' => false,
                    'read' => true,
                    'update' => false,
                    'delete' => false,
                ],
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Level::create($item);
        }
    }
}
