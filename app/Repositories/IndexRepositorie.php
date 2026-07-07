<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * class IndexRepositorie
 * 
 * @author Cesar Sergio <cesar.consuelo.cervantes@gmail.com>
 */
class IndexRepositorie
{
    public Model $model;
    
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}