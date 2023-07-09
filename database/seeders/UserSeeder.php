<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'=> Str::uuid(),
                'first_name'=> 'User',
                'last_name'=> 'Root',
                'email'=> 'root@mail.com',
                'password'=> 'root',
                'level_id'=> 1,
                'access_group_id'=> 1,
            ]
        ];

        foreach ($data as $item) {
            \App\Models\User::create($item);
        }
    }
}
