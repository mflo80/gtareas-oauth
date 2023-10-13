<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\EmailController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    public function generarToken(Request $request){
        try {
            $usuario = User::where('email', $request->email)->first();

            if($usuario){
                $token = Password::getRepository()->create($usuario);

                $datos = [
                    'email' => $usuario->email,
                    'nombre' => $usuario->nombre,
                    'apellido' => $usuario->apellido,
                    'titulo' => "Restablecer Contraseña",
                    'token' => $token
                ];

                $correoEstado = (new EmailController)->enviar($datos);

                if($correoEstado){
                    return response()->json([
                        'status' => true,
                        'message' => 'Revise su correo y siga las instrucciones.',
                    ], 200);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Error al enviar el correo.',
                ], 404);
            }

            return response()->json([
                'status' => false,
                'message' => 'Usuario no encontrado.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function modificar(Request $request, $codigo){
        try {
            $usuario = User::where('email', $request->email)->first();
            $usuario->password = Hash::make($request->password);
            $usuario->save();

            return response()->json([
                'status' => true,
                'message' => 'Contraseña modificada con éxito.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => true,
                'message' => 'Usuario no encontrado.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
