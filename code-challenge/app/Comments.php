<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    const MAX_COMMENT_LENGTH = 2 ** 16 - 1;

    protected $table = 'comments';
    protected $fillable = ['text'];
}
