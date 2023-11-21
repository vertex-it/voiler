<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
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

        $models = $this->getModels();

        $permissionTypes = config('voiler.permission_types');

        foreach ($models as $model) {
            foreach ($permissionTypes as $permissionType) {
                Permission::firstOrCreate(['name' => $model . ' ' . $permissionType]);
            }
        }

        Role::firstOrCreate(['name' => 'superadmin']);
        Role::firstOrCreate(['name' => 'user']);
    }

    protected function getModels()
    {
        $modelsPath = app_path('Models');

        $modelFiles = File::allFiles($modelsPath);

        $models = [];
        foreach ($modelFiles as $modelFile) {
            $models[] = $modelFile->getFilenameWithoutExtension();
        }

        return array_merge($models, [
            'Activity', 'Permission', 'Profile', 'Role'
        ]);
    }
}
