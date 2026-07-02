<?php

namespace App\Models\User;

trait UserActions
{
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