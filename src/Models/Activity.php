<?php

namespace VertexIT\Voiler\Models;


use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{
    public $guarded = [];

    public $titleColumn = 'log_name';

    public function getTitleColumn()
    {
        return $this->titleColumn;
    }
}
