<?php

namespace App\Models\User;

trait UserActions
{
    /**
     * Log the user in and generate an access token.
     * 
     * @param bool $create_token
     * @return array
     */
    public function login(bool $create_token = true): array
    {
        $access_token = $create_token ? $this->createToken('login')->accessToken : null;
        $user = $this->only([
            'id',
            'name',
            'email',
        ]);
        return ['access_token' => $access_token, 'user' => $user];
    }
}