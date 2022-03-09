<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();

        $adminRole = Role::create(
            [
                'name' => 'Admin',
                'description' => 'Admin',
                'created_at'        => new \dateTime,
                'updated_at'        => new \dateTime,
        ]);

        $managerRole = Role::create(
            [
                'name' => 'Manager',
                'description' => 'Manager',
                'created_at'        => new \dateTime,
                'updated_at'        => new \dateTime,
        ]);

        $memberRole = Role::create(
            [
                'name' => 'Member',
                'description' => 'Member',
                'created_at'        => new \dateTime,
                'updated_at'        => new \dateTime,
        ]);

        $admin = User::create([
                'name' => 'Admin',
                'username' => 'admin',
                'birthday' => '1999-01-01',
                'phone' => '0983940328',
                'email' => 'admin@sample.com',
                'password' => Hash::make('admin-password'),
                'store_id' => '1',
                'created_at'        => new \dateTime,
                'updated_at'        => new \dateTime,
        ]);

        $editor = User::create([
                'name' => 'Modular',
                'username' => 'mod',
                'birthday' => '1999-01-01',
                'phone' => '0983940329',
                'email' => 'mod@sample.com',
                'password' => Hash::make('mod-password'),
                'store_id' => '1',
                'created_at'        => new \dateTime,
                'updated_at'        => new \dateTime,
        ]);

        $user = User::create([
                'name' => 'Member',
                'username' => 'member',
                'birthday' => '1999-01-01',
                'phone' => '0983940326',
                'email' => 'member@sample.com',
                'store_id' => '1',
                'password' => Hash::make('member-password'),
                'created_at'        => new \dateTime,
                'updated_at'        => new \dateTime,
        ]);

        // add user to user role and admin to admin role
        $user->roles()->attach($memberRole);
        $user->roles()->attach($managerRole);
        $admin->roles()->attach($adminRole);
        $editor->roles()->attach($managerRole);

    }
}
