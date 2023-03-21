<?php

namespace VertexIT\Voiler\Models;

class Profile extends BaseModel
{
    protected $table = 'users';

    protected string | array $slugMap = 'name';

    protected string $titleColumn = 'name';

    protected $casts = [
        'emails' => 'array',
        'phone_numbers' => 'array',
    ];
}
