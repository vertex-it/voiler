<?php

if (! function_exists('flashSuccessMessage')) {
    function flashSuccessMessage($type = 'default', $model = null)
    {
        request()->session()
            ->flash('success', toastrMessage($type, $model));
    }
}

if (! function_exists('toastrMessage')) {
    function toastrMessage($type, $model)
    {
        if (isset($model) && method_exists($model, 'getTitle')) {
            $title = optional($model)->getTitle();
        } else {
            $title = $model->name ?? '';
        }

        return implode('', [__('toastr.' . $type), '<br>', $title]);
    }
}
