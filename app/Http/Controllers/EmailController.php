<?php

namespace App\Http\Controllers;

use App\Mail\EmailClass;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function enviar($datos){
        try {
            $mailData = [
                'titulo' => 'Gestor de Tareas - ' . $datos['titulo'],
                'body' => 'Hola ' . $datos['nombre'] . " " . $datos['apellido'],
                'token' => $datos['token'],
            ];

            Mail::to($datos['email'])->send(new EmailClass($mailData));

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
