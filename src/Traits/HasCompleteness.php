<?php

namespace VertexIT\Voiler\Traits;

trait HasCompleteness
{
    protected array $columnsForModelCompleteness;

    public function getModelCompletenessAttribute(): array
    {
        $emptyValues = [];
        foreach ($this->columnsForModelCompleteness as $key => $value) {
            if ($this->propertyIsFilled($value, $this->$key)) {
                continue;
            }

            $emptyValues[] = $key;
        }

        return [
            'completeness' => round(100 - (count($emptyValues) * 100 / count($this->columnsForModelCompleteness))),
            'empty_values' => $emptyValues,
        ];
    }

    private function propertyIsFilled(string $type, mixed $propertyValue): bool
    {
        switch ($type) {
            case 'string':
                return preg_replace("/\s+/", "", strip_tags($propertyValue));
            case 'array':
                return $this->isArrayNotEmpty($propertyValue);
        }
    }

    private function isArrayNotEmpty($propertyArrayValue): bool
    {
        if (! $propertyArrayValue) {
            return false;
        }

        $values = [];
        foreach ($propertyArrayValue as $value) {
            if (is_array($value)) {
                $this->isArrayNotEmpty($value);
            }

            $values[] = $value;
        }

        foreach ($values as $value) {
            if (json_decode(preg_replace("/\s+/", "", strip_tags(json_encode($value))))) {
                return true;
            }
        }

        return false;
    }
}