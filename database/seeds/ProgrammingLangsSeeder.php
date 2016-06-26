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
        \App\ProgrammingLanguage::create(['name' => 'c']);
        \App\ProgrammingLanguage::create(['name' => 'c++']);
        \App\ProgrammingLanguage::create(['name' => 'c#']);
        \App\ProgrammingLanguage::create(['name' => 'java']);
        \App\ProgrammingLanguage::create(['name' => 'assembly']);
    }
}
