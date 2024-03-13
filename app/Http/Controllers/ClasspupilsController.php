<?php

namespace App\Http\Controllers;

use App\Http\Resources\Classespupils\ClassespupilsCollection;
use App\Http\Resources\Classespupils\PupilsCollection;
use App\Http\Resources\Classes\ClassesCollection;;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Classes;
use App\Subject;

class ClasspupilsController extends Controller
{
   
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $class = Classes::all();
        return new ClassesCollection($class);
    }
    
    public function store(Request $request)
    {
  

    }

    public function show($name)
    {
        
        $pupils = DB::table('classes')
        ->join('pupils_class', 'pupils_class.class_id', '=', 'classes.id')
        ->rightjoin('users', 'pupils_class.user_id', '=', 'users.id')
        ->where('classes.classname',$name)
        ->select('users.id', 'users.username',  'users.firstname', 'users.lastname', 'pupils_class.created_at')
        ->paginate(1);

        $pupils = collect($pupils);

        return new ClassespupilsCollection($pupils);
    }

    public function update(Request $request, Classes $class)
    {
     
    }

   
    public function destroy(Classes $class)
    {
       
        
    }
}
