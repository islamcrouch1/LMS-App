<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users",
            'password' => "required|string|min:8|confirmed",
            'country' => "required",
            'phone' => "required|string",
            'gender' => "required",
            'profile' => "required|image",
            'type' => "required|string",
            'role' => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "errors" => $validator->errors()
            ] , 422);
        }

        
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'country_id' => $request['country'],
            'phone' => $request['phone'],
            'gender' => $request['gender'],
            'profile' => $request['profile']->store('images', 'public'),
            'type' => $request['type']
        ]);

        if($request['role'] == '3'){
            $user->attachRole($request['role']);
        }else{
            $user->attachRoles(['administrator' , $request['role']]);

        }


        return response()->json([
            "message" => "success",
        ] , 201);


    }

    public function login(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email' => "required|string|email|max:255|unique:users",
            'password' => "required|string|min:8|confirmed",
            'remember_me' => 'boolean',
        ]);

        $credentials = $request->only('email', 'password');

        if($token = $this->guard()->attempt($credentials)){
            return $this->respondWithToken($token);
        }

        return response()->json([
            "error" => "login_error"
        ] , 401);
        
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json(["data" => $user]);
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ] , 200);
    }

    private function guard(){
        return Auth::guard('api');
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}
