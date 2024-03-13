<?php

namespace App;

use App\Subject;
use App\Grade;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    
    public function subjects()
    {
        return $this->belongsTo(Subject::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    protected $fillable = [
        'testcode', 'name', 'date', 'subject_id'
    ];

}
