<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response    {
        try {
            $token = $request->bearerToken();
            if (!$token) {
                return response()->json([
                    'data' => null,
                    'statusCode' => 401,
                    'msg' => 'Token não encontrado.'
                ], 401);
            }

            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (ExpiredException $e) {
            return response()->json(['data' => null,'statusCode' => 402,'msg' => 'Token expirado.'], 401);
        } catch (Exception $e) {
            return response()->json(['data' => null,'statusCode' => 402,'msg' => 'Token é inválido.'], 401);
        }

        return $next($request);
    }
}
