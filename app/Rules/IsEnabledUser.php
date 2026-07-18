<?php

namespace App\Rules;

use App\Models\User\User;

class IsEnabledUser
{
    /**
     * Determine if the validation rule passes.
     * 
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return User::query()->where('email', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Este usuario no está registrado en el sistema.';
    }
}
