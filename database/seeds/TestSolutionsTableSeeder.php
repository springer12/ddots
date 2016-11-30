<?php

use App\Contest;
use App\Problem;
use App\Solution;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;

class TestSolutionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $contest = Contest::findOrFail(1);
        $problems = $contest->problems;
        $users = $contest->users;
        $languages = $contest->programming_languages;

        $generator = Faker\Factory::create();


        $solutions = factory(Solution::class, 10000)->make()
            ->each(function (Solution $solution) use ($contest, $problems, $users, $languages, $generator) {
                $solution->state = Solution::STATE_NEW;
                $solution->testing_mode = collect(['full', 'first_fail', 'one'])->random(1);
                $solution->problem_id = $problems->random(1)->id;

                $solution->programming_language_id = $languages->random(1)->id;

                $solution->user_id = $users->random(1)->id;
                $solution->created_at = Carbon::now();

                $solution->save();

                file_put_contents($solution->sourceCodeFilePath(), 'some code');

            });


        $contest->solutions()->saveMany($solutions);
    }
}
