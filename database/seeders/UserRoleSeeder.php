<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Purpose;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the 'admin' role if it does not exist
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Create a new user
        $user = User::create([
            'id' => '1',
            'name' => 'Abdul Basit',
            'email' => 'basit56700@gmail.com',
            'password' => bcrypt('44332211'), // Ensure you use a secure password in production
            'phone' => '03343459064',
        ]);
        $purpose = Purpose::create([
            'name' => 'Interview',
        ]);

        // Assign the 'admin' role to the user
        $user->assignRole($role);
    }
}
