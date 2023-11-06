<?php

namespace VertexIT\Voiler\ViewModels\Form;

use App\Models\User;

class UserFormViewModel extends BaseFormViewModel
{
    public $user;

    public function __construct(User $user)
    {
        parent::__construct($user);

        $this->user = $user;
    }
}
