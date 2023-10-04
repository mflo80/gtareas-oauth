<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Correo y/o contraseña incorrectos.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            $datos = (array) $user->createToken("access_token", ["*"], Carbon::now()->addMinutes(360));
            $token = $datos['plainTextToken'];

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

    public function logout(Request $request){
        try {
            $request->user()->currentAccessToken()->delete();

            Auth::logout();

            return response()->json([
                'status' => true,
                'message' => 'Se ha cerrado la sesión con éxito.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

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
                'message' => 'Registro correcto.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
