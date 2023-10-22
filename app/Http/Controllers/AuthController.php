<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credenciales = $request->only(['email', 'password']);

            if(!Auth::attempt($credenciales)){
                return response()->json([
                    'status' => false,
                    'message' => 'Correo y/o contraseña incorrectos.',
                ], 401);
            }

            $usuario = User::where('email', $request->email)->first();
            $datos = (array) $usuario->createToken("access_token", ["*"], Carbon::now()->addMinutes(getenv('SESSION_EXPIRATION')));
            $token = $datos['plainTextToken'];

            Cache::set($token, $usuario, getenv('SESSION_EXPIRATION'));

            return response()->json([
                'status' => true,
                'message' => 'Sesión iniciada correctamente',
                'token' => $token,
                ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $token = $request->bearerToken();
            Cache::delete($token);

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Sesión cerrada correctamente.',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
