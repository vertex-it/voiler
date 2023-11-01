<?php

namespace VertexIT\Voiler\Services;

use Illuminate\Support\Str;

class GuesserService
{
    /**
     * @param  string  $resourceName singular pascal case name of resource ex. Article, BlogCategory, etc.
     * @return string[]
     */
    private static function formResourceNameMapping(string $resourceName): array
    {
        $classNamespaces = [
            'model' => '\\Models',
            'request' => '\\Http\\Requests\\Admin',
            'policy' => '\\Policies\\Admin',
            'datatableService' => '\\Services\\Admin\\Datatable',
            'indexViewModel' => '\\ViewModels\\Admin\\Index',
            'formViewModel' => '\\ViewModels\\Admin\\Form',
        ];

        foreach ($classNamespaces as $type => $namespace) {
            $suffix = $type === 'model' ? '' : ucfirst($type);

            $fullNamespace = self::getClassFullNamespace('app', $namespace, $resourceName, $suffix);

            if (! class_exists($fullNamespace)) {
                $fullNamespace = str_replace(
                    '\Admin',
                    '',
                    self::getClassFullNamespace('voiler', $namespace, $resourceName, $suffix)
                );
            }

            $classNamespaces[$type] = $fullNamespace;
        }

        $view = view()->exists('admin.' . Str::of($resourceName)->kebab()->lower() . '.index') ?
            'admin.' . Str::of($resourceName)->kebab()->lower() :
            'voiler::admin.' . Str::of($resourceName)->kebab()->lower();

        return [
            'name' => $resourceName,
            'name_singular' => (string) Str::of($resourceName)->camel(),
            'name_plural' => (string) Str::of($resourceName)->plural()->camel(),
            'database_table' => (string) Str::of($resourceName)->plural()->snake(),
            'controller' => $resourceName . 'Controller',
            'controller_fqn' => '\\App\\Http\\Controllers\\Admin\\' . $resourceName . 'Controller',
            'api_controller' => $resourceName . 'APIController',
            'api_controller_fqn' => '\\App\\Http\\Controllers\\API\\' . $resourceName . 'APIController',
            'api_resource' => $resourceName . 'Resource',
            'api_resource_fqn' => '\\App\\Http\\Resources\\' . $resourceName . 'Resource',
            'route' => 'admin/' . Str::of($resourceName)->plural()->kebab()->lower(),
            'route_name' => 'admin.' . Str::of($resourceName)->plural()->kebab()->lower(),
            'route_suffix' => Str::of($resourceName)->plural()->kebab()->lower(),
            'model' => $resourceName,
            'model_fqn' => $classNamespaces['model'],
            'title_column' => class_exists($classNamespaces['model']) ? (new $classNamespaces['model'])->getTitleColumn() : '',
            'view_path' => (string) Str::of($resourceName)->kebab()->lower(),
            'view_full_path' => $view,
            'request' => $resourceName . 'Request',
            'request_fqn' => $classNamespaces['request'],
            'policy' => $resourceName . 'Policy',
            'policy_fqn' => $classNamespaces['policy'],
            'factory' => $resourceName . 'Factory',
            'factory_fqn' => '\\Database\\Factories\\' . $resourceName . 'Factory',
            'seeder' => $resourceName . 'Seeder',
            'seeder_fqn' => '\\Database\\Seeders\\' . $resourceName . 'Seeder',
            'datatable_service' => $resourceName . 'DatatableService',
            'datatable_service_fqn' => $classNamespaces['datatableService'],
            'index_view_model' => $resourceName . 'IndexViewModel',
            'index_view_model_fqn' => $classNamespaces['indexViewModel'],
            'form_view_model' => $resourceName . 'FormViewModel',
            'form_view_model_fqn' => $classNamespaces['formViewModel'],
            'title_singular' => (string) Str::of($resourceName)->headline(),
            'title_plural' => (string) Str::of($resourceName)->plural()->headline(),
            'roles' => self::generatePermissions($resourceName),
        ];
    }

    public static function fromModelName(string $resourceName): array
    {
        return self::formResourceNameMapping($resourceName);
    }

    public static function fromControllerName(string $className): array
    {
        $resourceName = self::getClassPrefixName($className, 'Controller');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromRequestName(string $className): array
    {
        $resourceName = self::getClassPrefixName($className, 'Request');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromAPIControllerName(string $className): array
    {
        $resourceName = self::getClassPrefixName($className, 'APIController');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromPolicyName(string $className): array
    {
        $resourceName = self::getClassPrefixName($className, 'Policy');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromIndexViewModelName(string $className): array
    {
        $resourceName = self::getClassPrefixName($className, 'IndexViewModel');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromFormViewModelName(string $className): array
    {
        $resourceName = self::getClassPrefixName($className, 'FormViewModel');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromDatatableServiceName(string $className): array
    {
        $resourceName = self::getClassPrefixName($className, 'DatatableService');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromFactoryName(string $className): array
    {
        $resourceName = self::getClassPrefixName($className, 'Factory');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromSeederName(string $className): array
    {
        $resourceName = self::getClassPrefixName($className, 'Seeder');

        return self::formResourceNameMapping($resourceName);
    }

    public static function getClassPrefixName(string $className, string $suffix)
    {
        $resourceName = explode('\\', $className);

        return str_replace($suffix, '', last($resourceName));
    }

    public static function getClassFullNamespace(string $vendor, string $namespace, string $resourceName, string $suffix): string
    {
        $prefix = $vendor === 'app' ? '\\App' : '\\VertexIT\\Voiler';

        return $prefix . $namespace . '\\' . $resourceName . $suffix;
    }

    private static function generatePermissions(string $resourceName): array
    {
        $permissionTypes = config('voiler.permission_types');

        $permissions = [];
        foreach ($permissionTypes as $permissionType) {
            $permissions[$permissionType] = $resourceName . ' ' . $permissionType;
        }

        return $permissions;
    }
}
