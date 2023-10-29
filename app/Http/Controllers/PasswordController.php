<?php

namespace App\Http\Controllers;

use App\Jobs\EmailJobs;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function generarToken(Request $request){
        try {
            $usuario = User::where('email', $request->email)->first();

            if($usuario){
                $token = Password::getRepository()->create($usuario);

                $datos = [
                    'from' => getenv('MAIL_FROM_ADDRESS'),
                    'to' => $usuario->email,
                    'subject' => 'Gestor de Tareas',
                    'nombre' => $usuario->nombre,
                    'apellido' => $usuario->apellido,
                    'titulo' => "Restablecer Contraseña",
                    'body' => 'Hola ' . $usuario->nombre . " " . $usuario->apellido,
                    'token' => $token
                ];

                dispatch(new EmailJobs($datos));

                return response()->json([
                    'status' => true,
                    'message' => 'Correo enviado con éxito.',
                    'datos' => $datos
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Usuario no encontrado.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error al enviar el correo.',
            ], 404);
        }
    }

    public function modificar(Request $request){
        try {
            Password::reset(
                $request->only('email', 'password', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            return response()->json([
                'status' => true,
                'message' => 'Contraseña modificada con éxito.',
                'email' => $request->email
            ], 200);
        } catch (ModelNotFoundException $ex) {
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
}
