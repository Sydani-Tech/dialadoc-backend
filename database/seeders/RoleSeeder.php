<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create base role(s)
        $superAdminRole = Role::create(['name' => 'super admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        $subscriberRole = Role::create(['name' => 'patient']);

        $doctorRole = Role::create(['name' => 'doctor']);

        $facilityRole = Role::create(['name' => 'facility']);

    }
}
