<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required'],
            ]);

        try {
            if($validator->fails()) {
                return response()->json([
                    'message' => 'Ошибка валидации',
                    'errors' => $validator->errors()
                ], 401);
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            return response()->json([
                'message' => 'Пользователь успешно создан',
                'token' => $user->createToken('api')->plainTextToken
            ], 200);

        } catch(\Throwable $th) {
            return response()->json([
                'message' => 'Ошибка. Пользователь не создан',
                'errors' => $validator->errors()
            ], 401);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
        ]);

    try {
        if($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ], 401);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'message' => 'Ошибка. Неверный логин или пароль',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        Auth::login($user);

        return response()->json([
            'message' => 'Пользователь авторизован',
            'token' => $user->createToken('api')->plainTextToken
        ], 200);

    } catch(\Throwable $th) {
        return response()->json([
            'message' => 'Ошибка',
            'errors' => $validator->errors()
        ], 401);
    }
    }
}
