<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private array $response = [
        'status' => 200, 'message' => 'OK', 'data' => NULL,
    ];

    public function formlogin()
    {
        return auth()->check() ? to_route('dashboard') : view('backend.auth.login');
    }

    public function formRegister()
    {
        return view('backend.auth.register');
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
            'last_name' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|string|min:8',
            'validate_password' => 'required|string|same:password|min:8',
            'agree_terms' => 'required',
        ]);
        if ($validation->fails()) {
            $this->response['status'] = 400;
            $this->response['message'] = 'Bad Request, please check your input';
            $this->response['data'] = $validation->errors();
        } else {
            $request->merge(['password' => $request->password,'level_id' => 3, 'access_group_id' => 3]);
            $this->response['data'] = User::create($request->all());
            $this->response['message'] = 'User created successfully';
        }
        return response()->json($this->response, $this->response['status']);
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email,deleted_at,NULL',
            'password' => 'required|string',
            'remember' => 'nullable|string|in:true,false',
        ]);
        if ($validation->fails()) {
            $this->response['status'] = 400;
            $this->response['message'] = 'Bad Request';
            $this->response['data'] = $validation->errors();
        } else {
            if ($user = User::where('email', $request->email)->first()) {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember == 'true')) {
                    $user->log()->create([
                        'ip' => $request->ip(), 'data' => [
                            'platform' => $request->device_name ?? 'web',
                            'browser' => $request->header('User-Agent') ?? 'web',
                        ], 'user_agent' => $request->userAgent(),
                    ]);
                    $this->response['message'] = 'User logged in successfully';
                } else {
                    $this->response['status'] = 401;
                    $this->response['message'] = 'Unauthorized Access, please check your credentials.';
                }
            } else {
                $this->response['status'] = 401;
                $this->response['message'] = 'Unauthorized Access, please check your credentials.';
            }
        }
        return response()->json($this->response, $this->response['status']);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        auth()->logout();
        Session()->flush();
        $this->response['message'] = 'User logged out successfully';
        return response()->json($this->response, $this->response['status']);
    }

    public function user()
    {
        $this->response['data'] = auth()->user();
        return response()->json($this->response, $this->response['status']);
    }
}
