<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function registrar(Request $request){
        try {
            $email = $request->post('email');
            $usuarioExistente = User::where('email', $email)->first();

            if ($usuarioExistente) {
                return response()->json([
                    'status' => false,
                    'message' => 'El correo ya se encuentra registrado.'
                ], 400);
            }

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

    public function buscar(){
        try {
            $usuarios = User::all();

            if($usuarios->isEmpty){
                return response()->json([
                    'status' => true,
                    'message' => 'No hay usuarios registrados.'
                ], 404);
            }

            return response()->json([
                'usuarios' => $usuarios,
                'status' => true,
                'message' => 'Usuarios encontrados.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function buscar_id($id){
        try {
            $usuario = User::findOrFail($id);

            return response()->json([
                'usuario' => $usuario,
                'status' => true,
                'message' => 'Usuario encontrado.'
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

    public function modificar(Request $request, $id){
        try {
            $usuario = User::findOrFail($id);
            $usuario->nombre = $request->nombre;
            $usuario->apellido = $request->apellido;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->save();

            return response()->json([
                'status' => true,
                'message' => 'Usuario actualizado con éxito.'
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

    public function eliminar($id){
        try {
            $usuario = User::findOrFail($id);
            $usuario->delete();

            return response()->json([
                'status' => true,
                'message' => 'Usuario eliminado con éxito.'
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
