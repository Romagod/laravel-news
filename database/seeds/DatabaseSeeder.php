<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('migrate:refresh');
        $this->call(UsersSeeder::class);
        $this->call(TagsSeeder::class);
        $this->call(PostsSeeder::class);

        Artisan::call('passport:install');
    }
}
