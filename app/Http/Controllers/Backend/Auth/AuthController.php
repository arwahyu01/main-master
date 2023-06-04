<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $response=[
        'status'=>200, 'message'=>'OK', 'data'=>NULL,
    ];

    public function formlogin()
    {
        if (auth()->check()) {
            return to_route('dashboard');
        }
        return view('backend.auth.login');
    }

    public function formRegister()
    {
        return view('backend.auth.register');
    }

    public function register(Request $request)
    {
        $validation=Validator::make($request->all(), [
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|string',
            'validate_password'=>'required|string|same:password',
            'agree_terms'=>'required',
        ]);
        if ($validation->fails()) {
            $this->response['status']=400;
            $this->response['message']='Bad Request';
            $this->response['data']=$validation->errors();
        }
        else {
            $data=User::create([
                'name'=>$request->name, 'email'=>$request->email, 'password'=>Hash::make(base64_decode($request->password)),
            ]);
            $this->response['data']=$data;
            $this->response['message']='User created successfully';
        }
        return response()->json($this->response, $this->response['status']);
    }

    public function login(Request $request)
    {
        $validation=Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required|string',
        ]);
        if ($validation->fails()) {
            $this->response['status']=400;
            $this->response['message']='Bad Request';
            $this->response['data']=$validation->errors();
        }
        else {
            if ($user=User::where('email', $request->email)->first()) {
                if (Auth::attempt(['email'=>$request->email, 'password'=>base64_decode($request->password)], $request->remember == 'true' ? true : false)) {
                    $token=$user->createToken($request->device_name)->plainTextToken;
                    $this->response['data']=[
                        'token'=>$token
                    ];
                    $this->response['message']='User logged in successfully';
                }
                else {
                    $this->response['status']=401;
                    $this->response['message']='Unauthorized Access, please check your credentials.';
                }
            }
        }
        return response()->json($this->response, $this->response['status']);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        Session()->flush();
        \auth()->logout();
        $this->response['message']='User logged out successfully';
        return response()->json($this->response, $this->response['status']);
    }

    public function user()
    {
        $this->response['data']=auth()->user();
        return response()->json($this->response, $this->response['status']);
    }
}
