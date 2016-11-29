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
        \App\ProgrammingLanguage::create(['name' => 'C (C89)', 'ace_mode' => 'c_cpp']);
        \App\ProgrammingLanguage::create(['name' => 'C (C11)', 'ace_mode' => 'c_cpp']);
        \App\ProgrammingLanguage::create(['name' => 'C++ (C++03)', 'ace_mode' => 'c_cpp']);
        \App\ProgrammingLanguage::create(['name' => 'C++ (C++03)', 'ace_mode' => 'c_cpp']);
        \App\ProgrammingLanguage::create(['name' => 'C++ (C++11)', 'ace_mode' => 'c_cpp']);
        \App\ProgrammingLanguage::create(['name' => 'C++ (C++14)', 'ace_mode' => 'c_cpp']);
        \App\ProgrammingLanguage::create(['name' => 'Pascal', 'ace_mode' => 'pascal']);
        \App\ProgrammingLanguage::create(['name' => 'Delphi', 'ace_mode' => '']);
        \App\ProgrammingLanguage::create(['name' => 'Java 7', 'ace_mode' => 'java']);
        \App\ProgrammingLanguage::create(['name' => 'Java 8', 'ace_mode' => 'java']);
        \App\ProgrammingLanguage::create(['name' => 'Scala', 'ace_mode' => 'scala']);
        \App\ProgrammingLanguage::create(['name' => 'Kotlin', 'ace_mode' => 'kotlin']);
        \App\ProgrammingLanguage::create(['name' => 'Go', 'ace_mode' => 'golang']);
        \App\ProgrammingLanguage::create(['name' => 'Haskell', 'ace_mode' => 'haskell']);
        \App\ProgrammingLanguage::create(['name' => 'Nim', 'ace_mode' => '']);
        \App\ProgrammingLanguage::create(['name' => 'Rust', 'ace_mode' => 'rust']);
        \App\ProgrammingLanguage::create(['name' => 'Python 2', 'ace_mode' => 'python']);
        \App\ProgrammingLanguage::create(['name' => 'Python 3', 'ace_mode' => 'python']);
        \App\ProgrammingLanguage::create(['name' => 'Ruby', 'ace_mode' => 'ruby']);
        \App\ProgrammingLanguage::create(['name' => 'PHP 5.6', 'ace_mode' => 'php']);
        \App\ProgrammingLanguage::create(['name' => 'Bash 4.3', 'ace_mode' => '']);
    }
}
