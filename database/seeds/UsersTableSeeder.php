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
            'name' => 'root',
            'password' => 'geRayay8',
            'role' => User::ROLE_ADMIN,
        ])->save();
    }
}
