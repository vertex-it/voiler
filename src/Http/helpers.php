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

if (! function_exists('prepareMultipleInputData')) {
    function prepareMultipleInputData($data)
    {
        $preparedData = [];

        // Map multiple values to subarrays
        foreach ($data as $property => $values) {
            foreach ($values as $index => $value) {
                $preparedData[$index][$property] = $value;
            }
        }

        // Remove subarrays if all values are null
        foreach ($preparedData as $key => $values) {
            if (count(array_unique($values)) === 1) {
                unset($preparedData[$key]);
            }
        }

        return $preparedData;
    }
}