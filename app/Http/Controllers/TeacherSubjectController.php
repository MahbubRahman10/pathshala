<?php

namespace App\Http\Controllers;

use App\Http\Resources\Teacher\TeacherSubjectCollection;
use App\Http\Resources\Teacher\TeacherTestCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Subject;

class TeacherSubjectController extends Controller
{
   
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = auth()->user();  

        $teachers = DB::table('users')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->join('subjects', 'subjects.user_id', '=', 'users.id')
        ->join('classes', 'subjects.class_id', '=', 'classes.id')
        ->where('users.id',$user->id)
        ->select('subjects.id', 'subjects.subjectcode',  'subjects.subjectname', 'classes.classname')
        ->paginate(4);

        $teachers = collect($teachers);

        return new TeacherSubjectCollection($teachers);
    }
    
    public function store(Request $request)
    {
    

    }

    public function show($id)
    {
        $tests = DB::table('tests')
        ->join('subjects', 'tests.subject_id', '=', 'subjects.id')
        ->where('subjects.id',$id)
        ->select('tests.id', 'tests.testcode',  'tests.name', 'tests.date', 'tests.created_at')
        ->paginate(7);

        $tests = collect($tests);

        return new TeacherTestCollection($tests);
    }

    public function update(Request $request, Classes $class)
    {
     
    }

   
    public function destroy(Classes $class)
    {
       
        
    }
}
