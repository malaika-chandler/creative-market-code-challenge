<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    const MAX_COMMENT_LENGTH = 1000;

    protected $table = 'comments';
    protected $fillable = ['text'];
}
