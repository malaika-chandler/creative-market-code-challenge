<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    const MAX_USERNAME_LENGTH = 25;

    protected $table = 'users';
    protected $fillable = ['username'];
}
