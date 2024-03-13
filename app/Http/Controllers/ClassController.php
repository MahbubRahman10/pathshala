<?php

namespace App\Http\Controllers;

use App\Http\Resources\Classes\ClassesResource;
use App\Http\Resources\Classes\ClassesCollection;
use App\Http\Resources\Classes\PupilsCollection;
use Illuminate\Http\Request;
use App\Http\Requests\Classes\ClassesRequest;
use App\Classes;
use App\Subject;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
   
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
     $class = Classes::orderby('id','desc')->paginate(5);
     return new ClassesCollection($class);

    }
    
    public function store(ClassesRequest $request)
    {
        $class = new Classes;   
        $class->classcode = substr(md5(rand()), 0, 4);
        $class->classname = $request->classname;
        $class->save();

        return response()->json(['message' => 'New Class Created Successfully'], 201);

    }

    public function show($name)
    {
        // return new ClassesResource($class);
        $class = Classes::where('classname',$name)->first();
        
        
        $exitpupils = DB::table('pupils_class')
        ->rightjoin('users', 'pupils_class.user_id', '=', 'users.id')
         ->join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->where([['roles.id',3], ['pupils_class.class_id','!=', $class->id]]);

         $pupils = DB::table('pupils_class')
        ->rightjoin('users', 'pupils_class.user_id', '=', 'users.id')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->where('roles.id',3)
        ->where('pupils_class.class_id','=', null)
        ->union($exitpupils)
        ->get();
  
        return new PupilsCollection($pupils);
    }

    public function update(Request $request, Classes $class)
    {
        $class->update($request->all());

        return Response()->json("Class Updated Successfully",201);
    }

   
    public function destroy(Classes $class)
    {
        $subjects = Subject::where('class_id', $class->id)->get();
        foreach ($subjects as $key => $subject) {
            if ($subject->subjectstatus == false) {
                $subject = Subject::find($subject->id);
                $subject->delete();
             } 
        }
        $class->delete();
        return Response()->json("Class Removed Successfully",201);
    }
}
