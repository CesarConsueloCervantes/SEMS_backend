<?php

namespace App\Rules;

use App\Models\User\User;
use Illuminate\Support\Facades\Hash;

class IsValidPassword
{
    private $email;

    /**
     * Create a new rule instance.
     * 
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Determine if the validation rule passes.
     * 
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::query()->where('email', $this->email)->first();
        if (! $user) {
            return true;
        }

        return Hash::check($value, $user->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Las credenciales no coinciden con nuestros registros.';
    }
}
