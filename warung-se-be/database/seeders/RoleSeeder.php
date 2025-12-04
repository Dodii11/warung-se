<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $role = ['user', 'admin', 'super admin'];

        foreach ($role as $role_name) {
            Role::create(['role_name' => $role_name]);
        }
    }
}
