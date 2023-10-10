<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function registro(Request $request){
        try {
            $usuario = new User();
            $usuario->nombre = $request->post('nombre');
            $usuario->apellido = $request->post('apellido');
            $usuario->email = $request->post('email');
            $usuario->password = Hash::make($request->post('password'));
            $usuario->remember_token = Str::random(60);
            $usuario->save();

            return response()->json([
                'status' => true,
                'message' => 'Registro correcto, confirme su correo.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
