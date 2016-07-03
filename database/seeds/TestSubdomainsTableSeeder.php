<?php

use App\Subdomain;
use Illuminate\Database\Seeder;


class TestSubdomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subdomain::create([
            'name' => 'ag45',
        ]);
        Subdomain::create([
            'name' => 'hneu',
        ]);
    }
}
