<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $registrationData = $request->all();
        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'birth_date' => 'required|date',
            'gender' => 'required',
            'address' => 'required|max:255',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]); //membuat rule validasi input

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input

        $registrationData['password'] = bcrypt($request->password); //enkripsi password

        $user = User::create($registrationData); //membuat user baru
        $user->sendApiEmailVerificationNotification(); // kirim email verification

        return response([
            'message' => 'Register Success, a verification email has been sent to your email address.',
            'user' => $user,
        ], 200); //return data user dalam bentuk json
    }

    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]); //membuat rule validasi input

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input

        if (!Auth::attempt($loginData))
            return response(['message' => 'Invalid Credentials'], 401); //return error gagal login

        $user = Auth::user();

        if ($user->email_verified_at == NULL) {
            return response([
                'message' => 'Please Verify Your Email'
            ], 401); //return error gagal login
        }

        $token = $user->createToken('Authentication Token')->accessToken; //generate token

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]); //return data user dan token dalam bentuk json
    }

    public function logout(Request $request)
    {
        $request->user()->token()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
