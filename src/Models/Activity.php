<?php

namespace VertexIT\Voiler\Models;


use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{
    public string $titleColumn = 'log_name';

    public function getTitleColumn(): string
    {
        return $this->titleColumn;
    }
}
