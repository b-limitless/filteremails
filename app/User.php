<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class User extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'email', 'password','created','updated', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   
}
