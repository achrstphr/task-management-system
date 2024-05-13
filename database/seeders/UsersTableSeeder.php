<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insert default users
        $adminRoleId = DB::table('roles')->insert([
            [
                'role_name' => 'Admin',
                'permission' => json_encode(['View Dashboard', 'Create Task', 'Manage Users']),
            ],
        ]);
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRoleId,
            ],
        ]);
    }
}
