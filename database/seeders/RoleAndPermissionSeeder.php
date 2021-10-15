<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use VertexIT\Voiler\Models\Permission;
use VertexIT\Voiler\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $models = [
            // Write your models here
        ];

        $modelPermissions = [];
        foreach ($models as $model) {
            $modelPermissions[] = $model . ' view';
            $modelPermissions[] = $model . ' create';
            $modelPermissions[] = $model . ' viewAny';
            $modelPermissions[] = $model . ' update';
            $modelPermissions[] = $model . ' delete';
            $modelPermissions[] = $model . ' restore';
            $modelPermissions[] = $model . ' forceDelete';
        }

        foreach ($modelPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'superadmin']);
    }
}
