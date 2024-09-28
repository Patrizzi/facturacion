<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProjectManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 4)->create();
        factory(App\ProjectService::class)->create();
        factory(App\ProjectManager::class)->create();
        factory(App\Activity::class, 5)->create();
        factory(App\Task::class, 120)->create();
        factory(App\Comment::class, 420)->create();
    }
}
