<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
     public function __construct()
     {
     	$this->middleware('auth:api', ['except' => ['index','register','login']]);
     }

     public function index()
     {
         return redirect('');
     }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'username' => 'required|string|max:255|unique:users',
    		'firstname' => 'required|string|max:255',
    		'lastname' => 'required|string|max:255',
    		'password' => 'required|string|min:6|confirmed',
    	]);

    	if($validator->fails()){
    		return response()->json($validator->errors()->toJson(), 400);
    	}

    	$user = User::create([
    		'userid' => substr(md5(rand()), 0, 6),
    		'username' => $request->get('username'),
    		'firstname' => $request->get('firstname'),
    		'lastname' => $request->get('lastname'),
    		'password' => Hash::make($request->get('password')),
    	]);

        DB::table('role_user')->insert([
            ['user_id' => $user->id, 'role_id' => $request->get('role')]
        ]);


    	return response()->json(['message' => 'User Created Successfully'], 201);
    }


    public function login()
    {    


    	$credentials = request(['username', 'password']);
    	if (! $token = auth()->attempt($credentials)) {
    		return response()->json(['error' => 'Unauthorized'], 401);
    	}

        $role = auth('api')->user()->roles->first()->name;

        return response()->json(['token' => $token, 'token_type' => 'bearer',  'role' => $role]);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
    	return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
    	auth()->logout();

    	return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
    	return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
    	return response()->json([
    		'access_token' => $token,
    		'token_type' => 'bearer',
    		'expires_in' => auth()->factory()->getTTL() * 60
    	]);
    }
}
