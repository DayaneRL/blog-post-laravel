<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objects = array(

			// ROOT

			array(
				'user_id' => 1, 
				'roles_id' => 1
			), 
			array(
				'user_id' => 1, 
				'roles_id' => 2
			), 
			array(
				'user_id' => 1, 
				'roles_id' => 3
			), 

			// ADMIN
			array(
				'user_id' => 2, 
				'roles_id' => 2
			), 
			array(
				'user_id' => 2, 
				'roles_id' => 3
			), 
		);

		// Uncomment the below to run the seeder
		DB::table('user_roles')->insert($objects);
    }
}
