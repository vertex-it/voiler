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
        $model = class_exists('\\VertexIT\\Voiler\\Models\\' . $resourceName) ?
            '\\VertexIT\\Voiler\\Models\\' . $resourceName :
            '\\App\\Models\\' . $resourceName;
        $request = class_exists('\\VertexIT\\Voiler\\Http\\Requests\\' . $resourceName . 'Request') ?
            '\\VertexIT\\Voiler\\Http\\Requests\\' . $resourceName . 'Request' :
            '\\App\\Http\\Requests\\Admin\\' . $resourceName . 'Request';
        $datatableService = class_exists('\\VertexIT\\Voiler\\Services\\Datatables\\' . $resourceName . 'DatatableService') ?
            '\\VertexIT\\Voiler\\Services\\Datatables\\' . $resourceName . 'DatatableService' :
            '\\App\\Services\\Datatables\\' . $resourceName . 'DatatableService';
        $indexViewModel = class_exists('\\VertexIT\\Voiler\\ViewModels\\Index\\' . $resourceName . 'IndexViewModel') ?
            '\\VertexIT\\Voiler\\ViewModels\\Index\\' . $resourceName . 'IndexViewModel' :
            '\\App\ViewModels\\Index\\' . $resourceName . 'IndexViewModel';
        $formViewModel = class_exists('\\VertexIT\\Voiler\\ViewModels\\Form\\' . $resourceName . 'FormViewModel') ?
            '\\VertexIT\\Voiler\\ViewModels\\Form\\' . $resourceName . 'FormViewModel' :
            '\\App\ViewModels\\Form\\' . $resourceName . 'FormViewModel';
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
            'model' => $model,
            'title_column' => class_exists($model) ? (new $model)->getTitleColumn() : '',
            'view' => $view,
            'request' => $request,
            'datatable_service' => $datatableService,
            'index_view_model' => $indexViewModel,
            'form_view_model' => $formViewModel,
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
