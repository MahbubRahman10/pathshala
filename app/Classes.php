<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = [
        'classcode', 'classname'
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    
}
