<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Models\User;
class loginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');
  
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = User::where("phone" , $request->phone)->first();


        // return response()->json(['data' => $user , 'access_token'=>$token ] , 200);

        $data = [
            'data' => $user,
            'access_token' => $token
        ];
        return response()->json($data, 200);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
