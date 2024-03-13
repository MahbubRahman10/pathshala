<?php

namespace App\Http\Controllers;

use App\Http\Resources\Teacher\TeacherCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Subject;

class TeacherController extends Controller
{
   
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $teachers = DB::table('users')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->where('roles.id',2)
        ->select('users.id', 'users.username',  'users.firstname', 'users.lastname')
        ->get();

        return new TeacherCollection($teachers);
    }
    
    public function store(Request $request)
    {
  

    }

    public function show($name)
    {
        
    }

    public function update(Request $request, Classes $class)
    {
     
    }

   
    public function destroy(Classes $class)
    {
       
        
    }
}
