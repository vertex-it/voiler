<?php

namespace VertexIT\Voiler\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    protected array $baseRules = [];

    protected array $POSTRules = [];

    protected array $PUTRules = [];

    protected array $PATCHRules = [];

    public function rules(): array
    {
        $methodRulesName = 'get' . $this->method() . 'Rules';

        if ($this->method() === 'PUT' && count($this->getPUTRules()) === 0) {
            $methodRulesName = 'getPATCHRules';
        }

        return array_merge($this->getBaseRules(), $this->{$methodRulesName}());
    }

    public function getBaseRules(): array
    {
        return $this->baseRules;
    }

    public function getPOSTRules(): array
    {
        return $this->POSTRules;
    }

    public function getPUTRules(): array
    {
        return $this->PUTRules;
    }

    public function getPATCHRules(): array
    {
        return $this->PATCHRules;
    }
}
