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
        \App\ProgrammingLanguage::create(['name' => 'C', 'ace_mode' => 'c_cpp']);
        \App\ProgrammingLanguage::create(['name' => 'C++', 'ace_mode' => 'c_cpp']);
        \App\ProgrammingLanguage::create(['name' => 'C#', 'ace_mode' => 'csharp']);
        \App\ProgrammingLanguage::create(['name' => 'Java', 'ace_mode' => 'java']);
        \App\ProgrammingLanguage::create(['name' => 'JavaScript', 'ace_mode' => 'javascript']);
        \App\ProgrammingLanguage::create(['name' => 'PHP', 'ace_mode' => 'php']);
        \App\ProgrammingLanguage::create(['name' => 'Assembly x86', 'ace_mode' => 'assembly_x86']);
    }
}
