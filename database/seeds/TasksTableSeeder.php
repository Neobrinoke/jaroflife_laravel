<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                DB::table('tasks')->insert([
                    'name' => 'Tâche ' . $j,
                    'description' => 'Description' . $j,
                    'author_id' => 1,
                    'priority' => 0,
                    'todo_id' => $i,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }
    }
}
