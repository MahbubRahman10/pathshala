<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pupils extends Model
{
    
    protected $table = 'pupils_class';

    protected $fillable = [
        'class_id', 'user_id'
    ];

}
