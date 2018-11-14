<?php

use Illuminate\Database\Seeder;
use MyDesigner\Models\User;
use MyDesigner\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where('role_name', 'admin')->first();
		$role_user  = Role::where('role_name', 'user')->first();
		$role_designer  = Role::where('role_name', 'designer')->first();
		$role_manager  = Role::where('role_name', 'manager')->first();

		$admin = new User();
		$admin->first_name = 'Lester';
		$admin->last_name = 'Joson';
		$admin->email = 'lesz_03@yahoo.com';
		$admin->password = Hash::make('secret');
		$admin->user_status = '0';
		$admin->save();
		$admin->roles()->attach($role_admin);

		$user = new User();
		$user->first_name = 'John';
		$user->last_name = 'Doe';
		$user->email = 'lester@podcastwebsites.com';
		$user->password = Hash::make('secret');
		$user->user_status = '0';
		$user->save();
		$user->roles()->attach($role_user);

		$designer = new User();
		$designer->first_name = 'Jane';
		$designer->last_name = 'Doe';
		$designer->email = 'hana@podcastwebsites.com';
		$designer->password = Hash::make('secret');
		$designer->user_status = '0';
		$designer->save();
		$designer->roles()->attach($role_designer);

		$manager = new User();
		$manager->first_name = 'Podcast Websites';
		$manager->last_name = 'Dev';
		$manager->email = 'podcastwebsites.dev@gmail.com';
		$manager->password = Hash::make('secret');
		$manager->user_status = '0';
		$manager->save();
		$manager->roles()->attach($role_manager);
    }
}
