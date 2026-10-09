<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required']
        ]);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'نام کاربری یا رمز عبور اشتباه است.'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'ورود با موفقیت انجام شد.',
            'user' => $user,
            'token' => $token
        ]);
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'با موفقیت خارج شدید'
        ]);
    }
    public function changePassword(Request $request){
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required','min:2','confirmed']
        ]);
        $user = $request->user();
        if(!Hash::check($request->current_password, $user->password)){
            return response()->json([
                'message'=> 'رمز عبور فعلی اشتباه است'
            ],422);
        }
        $user->password = $request->password;
        $user->save();
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'رمز عبور با موفقیت تغییر کرد'
        ]);
    }

    public function updateProfile(Request $request){
        $user = $request->user();
        $data = $request->validate([
            'email' => ['required','email','max:255']
        ]);
        $user->update($data);
        return response()->json([
            'message' => 'اطلاعات کاربر با موفقیت به روزرسانی شد',
            'user'    => $user
        ]);
    }
}

