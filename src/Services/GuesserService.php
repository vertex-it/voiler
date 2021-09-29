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
        $model = '\\VertexIT\\Voiler\\Models\\' . $resourceName;
        $request = '\\VertexIT\\Voiler\\Http\\Requests\\' . $resourceName . 'Request';

        if (! class_exists($model)) {
            $model = '\\App\\Models\\Admin\\' . $resourceName;
        }

        if (! class_exists($request)) {
            $request = '\\App\\Http\\Requests\\Admin\\' . $resourceName . 'Request';
        }

        return [
            'name' => $resourceName,
            'name_singular' => (string) Str::of($resourceName)->camel(),
            'name_plural' => (string) Str::of($resourceName)->plural()->camel(),
            'controller' => $resourceName . 'Controller',
            'controller_fqn' => '\\App\\Http\\Controllers\\Admin\\' . $resourceName . 'Controller',
            'route' => 'admin/' . strtolower(Str::plural($resourceName)),
            'route_name' => 'admin.' . Str::of($resourceName)->plural()->kebab()->lower(),
            'model' => $model,
            'title_column' => class_exists($model) ? (new $model)->getTitleColumn() : '',
            'view' => 'admin.' . Str::of($resourceName)->kebab()->lower(),
            'request' => $request,
            'datatable_service' => '\\App\\Services\\Datatables\\' . $resourceName . 'DatatableService',
            'index_view_model' => '\\App\ViewModels\\Index\\' . $resourceName . 'IndexViewModel',
            'form_view_model' => '\\App\ViewModels\\Form\\' . $resourceName . 'FormViewModel',
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
}
