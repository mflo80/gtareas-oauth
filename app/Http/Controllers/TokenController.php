<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class TokenController extends Controller
{
    public function verificar_token(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        if ($this->es_token_valido($token)) {
            $usuario = Cache::get($token);
            Cache::put($token, $usuario, Carbon::now()->addMinutes(getenv('SESSION_EXPIRATION')));
            return response()->json([
                'usuario' => $usuario,
                'message' => 'Token válido.'
            ], 200);
        }

        return response()->json([
            'message' => 'Token inválido.'
        ], 401);
    }

    private function es_token_valido($token)
    {
        if(Cache::get($token) !== null){
            return true;
        }

        return false;
    }
}
