<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Emailaddress extends Eloquent
{
   	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'email', 'sendInvitation', 'is_deleted', 'updated_at', 'created_at', 'is_valid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        ''
    ];
}
