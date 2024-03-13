<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Requests\User\UserRequest;
use App\User;
use App\Subject;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {   
        $user = User::with('roles')->orderby('id','desc')->paginate(10);
        return new UserCollection($user);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return Response()->json("User Updated Successfully",200);
    }

    public function destroy(User $user)
    {
        foreach ($user->roles as $role) {            
            $userrole = $role->name;
        }
        if ($userrole == 'Teacher') {
            $subject = Subject::where('user_id',$user->id)->first();
            if ($subject != null) {
                return Response()->json("Teacher Can not be Deleted",304);
            }
        }
        $user->delete(); 
        return Response()->json( $userrole. " Deleted Successfully",200);
    }
}
