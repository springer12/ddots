<?php

use App\Contest;
use App\Problem;
use App\Solution;
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

        $generator = Faker\Factory::create();


        $solutions = factory(Solution::class, 2000)->make()
            ->each(function (Solution $solution) use ($contest, $problems, $users, $generator) {
                $solution->state = Solution::STATE_TESTED;
                $solution->status = Solution::STATUS_CE;
                $solution->testing_mode = 'full';
                $solution->problem_id = $problems->random(1)->id;
                $solution->programming_language_id = 1;
                $solution->user_id = $users->random(1)->id;
                $solution->created_at = $generator->date();
                $solution->success_percentage = rand(0, 100);
                if($solution->success_percentage == 100) {
                    $solution->state = Solution::STATE_TESTED;
                    $solution->status = Solution::STATUS_OK;
                }

                $solution->save();
            });


        $contest->solutions()->saveMany($solutions);
    }
}
