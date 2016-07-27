<?php

use App\User;
use Illuminate\Database\Seeder;


class TestUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)->create();
        factory(User::class, 50)->create()->each(function (User $user) {
            $user->role = User::ROLE_TEACHER;
            $user->students()->attach(User::user()->orderByRaw("RAND()")->take(1)->get());
            $user->subdomains()->attach(\App\Subdomain::orderByRaw("RAND()")->take(1)->get());
            $user->save();
        });
    }
}
