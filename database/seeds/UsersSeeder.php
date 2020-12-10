<?php

use App\Eloquent\Roles;
use App\Eloquent\User;
use Illuminate\Database\Seeder;
use App\Eloquent\Option;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Roles::where('name', 'default')->first();
        if (!$role) {
            $role = new Roles();
            $role->name = 'default';
            $role->save();
        }
        $role = Roles::where('name', 'admin')->first();
        if (!$role) {
            $role = new Roles();
            $role->name = 'admin';
            $role->save();
        }
        User::register((object) array(
            'username' => 'Admin',
            'email' => env('ADMIN_EMAIL', 'admin@romagod.ru'),
            'password' => env('ADMIN_PASS', '123456'),
        ), 'admin');
    }
}
