<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials=$request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $user=auth()->user();
            $token=$user->createToken(uniqid().now())->plainTextToken;
            $response=[
                'status'=>true,
                'message'=>'Login success',
                'data'=>[
                    'user'=>$user,
                    'token'=>$token,
                ],
            ];
        }
        return response()->json($response ?? ['status'=>false, 'message'=>'Login failed']);
    }
}
