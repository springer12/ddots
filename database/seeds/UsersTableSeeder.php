<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nickname' => 'root',
            'email'    => 'ag45root@gmail.com',
            'password' => 'geRayay8',
            'role'     => User::ROLE_ADMIN,
        ])->save();
    }
}
