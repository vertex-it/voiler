<?php

namespace VertexIT\Voiler\ViewModels\Form;

use VertexIT\Voiler\Models\Profile;

class ProfileFormViewModel extends BaseFormViewModel
{
    public $profile;

    public function __construct(Profile $profile)
    {
        parent::__construct($profile);

        $this->profile = $profile;
    }

    public function emails()
    {
        if (old('emails') && count(old('emails'))) {
            return old('emails');
        }

        if (isset($this->profile->emails) && count($this->profile->emails)) {
            return $this->profile->emails;
        }

        return [''];
    }

    public function phoneNumbers()
    {
        if (old('phone_numbers') && count(old('phone_numbers'))) {
            return old('phone_numbers');
        }

        if (isset($this->profile->phone_numbers) && count($this->profile->phone_numbers)) {
            return $this->profile->phone_numbers;
        }

        return [''];
    }
}
