<?php

use Illuminate\Database\Seeder;
use MyDesigner\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
		$role_admin->role_name = 'admin';
		$role_admin->save();

		$role_user = new Role();
		$role_user->role_name = 'user';
		$role_user->save();

		$role_designer = new Role();
		$role_designer->role_name = 'designer';
		$role_designer->save();
		
		$role_manager = new Role();
		$role_manager->role_name = 'manager';
		$role_manager->save();
    }
}
