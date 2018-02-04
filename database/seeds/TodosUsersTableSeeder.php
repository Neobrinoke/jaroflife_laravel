<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodosUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('todos_users')->insert([
                'user_id' => $i,
                'todo_id' => 1,
                'authority_id' => 1,
                'joined_at' => Carbon::now()
            ]);
        }
    }
}
