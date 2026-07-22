<?php

namespace App\Repositories\User;

use App\Models\User\User;
use App\Repositories\IndexRepositorie;

/**
 * class UserRepositorie
 * 
 * @author Cesar Sergio <cesar.consuelo.cervantes@gmail.com>
 */
class UserRepositorie extends IndexRepositorie
{
    public function __construct(User $user) {
        $this->model = $user;
    }
}