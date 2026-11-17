<?php

namespace VertexIT\Voiler\Tests\Fixtures;

use VertexIT\Voiler\Models\BaseModel;

class CompatibilityModel extends BaseModel
{
    protected $table = 'compatibility_models';

    protected string $titleColumn = 'name';

    protected array|string $slugMap = 'name';
}
