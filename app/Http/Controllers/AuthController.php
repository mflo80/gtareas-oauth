<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Error al validar datos',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Correo y/o contraseña incorrectos.',
                ], 401);
            }

            $datos = [
                'email' => 'juan.perez@example.com',
                'password' => '123456'
            ];

            $user = User::where('email', $request->email)->first();
            $datos = (array) $user->createToken("api_token", ["*"], Carbon::now()->addMinutes(10));
            $token = $datos['plainTextToken'];
            $user->token = $token;
            $user->save();

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

            $email = auth()->user()->email;
            $user = User::where('email', $email)->first();
            $user->token = null;
            $user->save();

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
}
