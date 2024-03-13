<?php

namespace App;
use App\User;
use App\Test;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'test_id', 'user_id', 'grade'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
