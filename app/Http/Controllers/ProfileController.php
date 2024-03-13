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
use Hash;

class ProfileController extends Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {   
        $id = auth()->user()->id;
        $user = User::find($id);
        return new UserResource($user);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user, $id)
    {
        if ($request->flag == 1) {
            // $validated = $request->validate([
            //   'current_password' => 'required',
            //   'password' => 'required|string|min:6|confirmed',
            //   'password_confirmation' => 'required',
            // ]);
            // if ($validated->fails()) {
            //     return Response()->json($validator,404);
            // }
            $user = User::find($id);
            if (!Hash::check($request->current_password, $user->password)) {
                return Response()->json("Current password does not match!",404);
            }
            $user->password = Hash::make($request->password);
            $user->save();
            return Response()->json("Password Changed Successfully",200);
        }
        else{
            $user->update($request->all());
            return Response()->json("User Updated Successfully",200);
        }
    }

    public function destroy(User $user)
    {
       
    }
}
