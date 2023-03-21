<?php

if (! function_exists('flashSuccessMessage')) {
    function flashSuccessMessage($type = 'default', $model = null): void
    {
        request()
            ->session()
            ->flash('success', toastrMessage($type, $model));
    }
}

if (! function_exists('toastrMessage')) {
    function toastrMessage($type, $model): string
    {
        if (isset($model) && method_exists($model, 'getTitle')) {
            $title = optional($model)->getTitle();
        } else {
            $title = $model->name ?? '';
        }

        return implode('', [__('voiler::toastr.' . $type), '<br>', $title]);
    }
}
