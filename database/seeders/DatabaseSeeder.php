<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
         $this->call([
             LevelSeeder::class,
             AccessGroupSeeder::class,
             MenuSeeder::class,
             UserSeeder::class,
             AccessMenuSeeder::class,
         ]);
         $this->command->info('Seeder successfully.');
         $this->command->info('Please login with email: root@mail.com and password: root');
    }
}
