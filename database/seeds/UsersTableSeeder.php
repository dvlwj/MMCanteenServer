<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = ['admin', 'petugas'];
        foreach($users as $user){
            DB::table('users')->insert([
                'username' => $user,
                'password' => bcrypt('password'),
                'role' => $user,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s") 
            ]);
        }
    }
}
