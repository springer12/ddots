<?php

use Illuminate\Database\Seeder;

class ProgrammingLangsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('programming_languages')->insert([
            ['name' => 'c'],
            ['name' => 'c++'],
            ['name' => 'c#'],
            ['name' => 'java'],
            ['name' => 'assembly'],
        ]);
    }
}
