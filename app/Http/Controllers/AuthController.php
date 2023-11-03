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
            $token = $datos['accessToken'];

            Cache::put($token, $usuario, Carbon::now()->addMinutes(getenv('SESSION_EXPIRATION')));

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

            if (isset($token)) {
                if (Cache::get($token) === null) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tu sesión ha expirado.',
                    ], 403);
                }

                Cache::delete($token);
                $request->user()->token()->revoke();

                return response()->json([
                    'status' => true,
                    'message' => 'Sesión cerrada correctamente.',
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'No se ha encontrado el token.',
            ], 404);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function verificar_token(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        if ($this->es_token_valido($token)) {
            return response()->json(['message' => 'Token válido.']);
        } else {
            return response()->json(['message' => 'Token inválido.'], 401);
        }
    }

    private function es_token_valido($token)
    {
        if(Cache::get($token) !== null){
            return true;
        }

        return false;
    }
}
