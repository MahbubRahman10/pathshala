<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Role\RoleCollection;

use App\Http\Requests\Role\RoleRequest;
use App\Role;


class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $role = Role::all();
        return new RoleCollection($role);
    }

    public function store(RoleRequest $request)
    {
       
        $role = new Role;   
        $role->name = $request->name;
        $role->save();

        return response()->json(['message' => 'New role Created Successfully'], 201);
    }

    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->all());

        return Response()->json("Role Updated Successfully",201);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return Response()->json("Role Removed Successfully",201);
    }
}
