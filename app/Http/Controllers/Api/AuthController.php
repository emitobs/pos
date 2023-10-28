<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Obtener el usuario autenticado
        $user = JWTAuth::user();

        // Añadir la información adicional
        $customClaims = [
            'name' => $user->name,
            'otra_info' => 'otro_valor'
        ];

        // Crear un token personalizado
        $token = JWTAuth::fromUser($user, $customClaims);

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Successfully logged out']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to logout, please try again.'], 500);
        }
    }
}
