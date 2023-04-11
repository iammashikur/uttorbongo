<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list branches']);
        Permission::create(['name' => 'view branches']);
        Permission::create(['name' => 'create branches']);
        Permission::create(['name' => 'update branches']);
        Permission::create(['name' => 'delete branches']);

        Permission::create(['name' => 'list brands']);
        Permission::create(['name' => 'view brands']);
        Permission::create(['name' => 'create brands']);
        Permission::create(['name' => 'update brands']);
        Permission::create(['name' => 'delete brands']);

        Permission::create(['name' => 'list buyers']);
        Permission::create(['name' => 'view buyers']);
        Permission::create(['name' => 'create buyers']);
        Permission::create(['name' => 'update buyers']);
        Permission::create(['name' => 'delete buyers']);

        Permission::create(['name' => 'list dues']);
        Permission::create(['name' => 'view dues']);
        Permission::create(['name' => 'create dues']);
        Permission::create(['name' => 'update dues']);
        Permission::create(['name' => 'delete dues']);

        Permission::create(['name' => 'list products']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'update products']);
        Permission::create(['name' => 'delete products']);

        Permission::create(['name' => 'list productcategories']);
        Permission::create(['name' => 'view productcategories']);
        Permission::create(['name' => 'create productcategories']);
        Permission::create(['name' => 'update productcategories']);
        Permission::create(['name' => 'delete productcategories']);

        Permission::create(['name' => 'list productcodes']);
        Permission::create(['name' => 'view productcodes']);
        Permission::create(['name' => 'create productcodes']);
        Permission::create(['name' => 'update productcodes']);
        Permission::create(['name' => 'delete productcodes']);

        Permission::create(['name' => 'list sales']);
        Permission::create(['name' => 'view sales']);
        Permission::create(['name' => 'create sales']);
        Permission::create(['name' => 'update sales']);
        Permission::create(['name' => 'delete sales']);

        Permission::create(['name' => 'list sellers']);
        Permission::create(['name' => 'view sellers']);
        Permission::create(['name' => 'create sellers']);
        Permission::create(['name' => 'update sellers']);
        Permission::create(['name' => 'delete sellers']);

        Permission::create(['name' => 'list shops']);
        Permission::create(['name' => 'view shops']);
        Permission::create(['name' => 'create shops']);
        Permission::create(['name' => 'update shops']);
        Permission::create(['name' => 'delete shops']);

        Permission::create(['name' => 'list suppliers']);
        Permission::create(['name' => 'view suppliers']);
        Permission::create(['name' => 'create suppliers']);
        Permission::create(['name' => 'update suppliers']);
        Permission::create(['name' => 'delete suppliers']);

        Permission::create(['name' => 'list supplierreturns']);
        Permission::create(['name' => 'view supplierreturns']);
        Permission::create(['name' => 'create supplierreturns']);
        Permission::create(['name' => 'update supplierreturns']);
        Permission::create(['name' => 'delete supplierreturns']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
