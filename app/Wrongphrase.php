<?php

namespace App;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Wrongphrase extends Eloquent
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'title'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}



