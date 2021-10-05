<?php

namespace VertexIT\Voiler\Models;

class Profile extends BaseModel
{
    protected $table = 'users';

    protected $slugMap = 'name';

    protected $titleColumn = 'name';

    protected $casts = [
        'emails' => 'array',
        'phone_numbers' => 'array',
    ];
}
