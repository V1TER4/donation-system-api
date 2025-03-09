<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'name.required' => 'O campo usuário é obrigatório.',
                'email.required' => 'O campo email é obrigatório.',
                'email.exists' => 'A instituição financeira informada não existe.',
                'password.required' => 'O campo senha é obrigatório.',
                'password.confirmed' => 'As senhas não coincidem.',
                'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
                'password_confirmation.required' => 'É necessário confirmar a senha.',
            ]);

    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $token = JWTAuth::fromUser($user);
    
            DB::commit();

            return response()->json(compact('user', 'token'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
            return response()->json(['error' => 'Erro ao cadastrar usuário'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $credentials = $request->only('email', 'password');
        
            // if (!$token = JWTAuth::attempt($credentials)) {
            //     return response()->json(['error' => 'Unauthorized'], 401);
            // }
        
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'Usuario / Senha invalido(s)'], 401);
            }
            $api_token = $this->jwt($user);
            $user->api_token = $api_token;
            $user->save();
        
            return response()->json(['data' => $user, 'token' => $api_token]);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return response()->json(['error' => 'Erro ao logar'], 500);
        }
    }

    protected function jwt($user)
    {
        $time = (int) env('JWT_EXPIRED_TIME', 10);

        $payload = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + $time
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}
