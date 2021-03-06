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
            'phone' => 'required|digits_between:10,13',
            'birth_date' => 'required|date',
            'gender' => 'required',
            'address' => 'required|max:255',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'image64' => 'nullable'
        ]); // membuat rule validasi input

        if ($validate->fails())
            return response([
                'message' => $validate->errors()
            ], 400); // return error invalid input

        $registrationData['password'] = bcrypt($request->password); // enkripsi password

        $user = User::create($registrationData); // membuat user baru
        $user->sendApiEmailVerificationNotification(); // kirim email verifikasi

        return response([
            'message' => 'Register Success, a verification email has been sent to your email address.',
            'user' => $user,
        ], 200); // return data user dalam bentuk json
    }

    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]); // membuat rule validasi input

        if ($validate->fails())
            return response([
                'message' => $validate->errors()
            ], 400); // return error jika input tidak valid

        if (!Auth::attempt($loginData))
            return response([
                'message' => 'Invalid Credentials'
            ], 401); // return error jika data salah atau tidak ditemukan

        $user = Auth::user();

        if ($user->email_verified_at == NULL) {
            return response([
                'message' => 'Please Verify Your Email'
            ], 401); // return error jika belum verifikasi email
        }

        $token = $user->createToken('Authentication Token')->accessToken; // generate token

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ], 200); // return data user dan token dalam bentuk json
    }

    public function logout(Request $request)
    {
        $request->user()->token()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function details()
    {
        $user = Auth::user();

        if (is_null($user)) {
            return response([
                'message' => 'User Not Found',
            ], 404);
        }

        return response([
            'message' => 'User Data Retrieved',
            'user' => $user,
        ], 200); // return data user dalam bentuk json
    }

    public function update(Request $request)
    {
        $user = Auth::User();

        if (is_null($user))
            return response([
                'message' => 'User not found!'
            ], 404);

        $data = $request->all();
        $validate = Validator::make($data, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|digits_between:10,13',
            'birth_date' => 'required|date',
            'gender' => 'required',
            'address' => 'required|max:255',
            'image64' => 'nullable',
        ]);

        if ($validate->fails())
            return response([
                'message' => $validate->errors()
            ], 400);

        if (isset($data['image64'])) {
            $user->image64 = $data['image64'];
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->birth_date = $data['birth_date'];
        $user->gender = $data['gender'];
        $user->address = $data['address'];


        if ($user->save())
            return response([
                'message' => 'Update Success',
                'user' => $user
            ], 200);

        return response([
            'message' => 'Update User Failed'
        ], 400);
    }
}
