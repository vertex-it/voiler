<?php

namespace VertexIT\Voiler\Services;

use Illuminate\Support\Facades\Route;
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
            'request' => '\\Http\\Requests',
            'datatableService' => '\\Services\\Datatables',
            'indexViewModel' => '\\ViewModels\\Index',
            'formViewModel' => '\\ViewModels\\Form',
        ];

        foreach ($classNamespaces as $type => $namespace) {
            $suffix = $type === 'model' ? '' : ucfirst($type);

            $fullNamespace = self::getClassFullNamespace('app', $namespace, $resourceName, $suffix);

            if (! class_exists($fullNamespace)) {
                $fullNamespace = self::getClassFullNamespace('voiler', $namespace, $resourceName, $suffix);
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
            'controller' => $resourceName . 'Controller',
            'controller_fqn' => '\\App\\Http\\Controllers\\Admin\\' . $resourceName . 'Controller',
            'route' => 'admin/' . strtolower(Str::plural($resourceName)),
            'route_name' => 'admin.' . Str::of($resourceName)->plural()->kebab()->lower(),
            'model' => $classNamespaces['model'],
            'title_column' => class_exists($classNamespaces['model']) ? (new $classNamespaces['model'])->getTitleColumn() : '',
            'view' => $view,
            'request' => $classNamespaces['request'],
            'datatable_service' => $classNamespaces['datatableService'],
            'index_view_model' => $classNamespaces['indexViewModel'],
            'form_view_model' => $classNamespaces['formViewModel'],
        ];
    }

    public static function fromControllerName(string $className): array
    {
        $resourceName = self::getClassPrefixName($className, 'Controller');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromPolicyName(string $className): array
    {
        $resourceName = self::getClassPrefixName($className, 'Policy');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromIndexViewModelName(string $className)
    {
        $resourceName = self::getClassPrefixName($className, 'IndexViewModel');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromFormViewModelName(string $className)
    {
        $resourceName = self::getClassPrefixName($className, 'FormViewModel');

        return self::formResourceNameMapping($resourceName);
    }

    public static function fromDatatableServiceName(string $className)
    {
        $resourceName = self::getClassPrefixName($className, 'DatatableService');

        return self::formResourceNameMapping($resourceName);
    }

    public static function getClassPrefixName(string $className, string $suffix)
    {
        $resourceName = explode('\\', $className);

        return str_replace($suffix, '', last($resourceName));
    }

    public static function getClassFullNamespace(string $vendor, string $namespace, string $resourceName, string $suffix)
    {
        $prefix = $vendor === 'app' ? '\\App' : '\\VertexIT\\Voiler';

        return $prefix . $namespace . '\\' . $resourceName . $suffix;
    }
}
