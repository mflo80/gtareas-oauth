<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AuthTest extends TestCase
{

    private $campos = [
        "id",
        "nombre",
        "apellido",
        "email",
        "email_verified_at",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function test_login_correcto()
    {
        $datoslogin = [
            'email' => 'juan.perez@example.com',
            'password' => '123456',
        ];

        $response = $this->call('POST', '/api/login', $datoslogin);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(Auth::check());
        $response->assertJsonFragment([
            "status" => true,
            "message" => "Sesión iniciada correctamente"
        ]);
    }

    public function test_login_incorrecto()
    {
        $datoslogin = [
            'email' => 'juan.perez@example.com',
            'password' => '1234567',
        ];

        $response = $this->call('POST', '/api/login', $datoslogin);
        $response->assertJsonFragment([
            "status" => false,
            "message" => "Correo y/o contraseña incorrectos."
        ]);
    }

    public function test_login_sin_cargar_datos()
    {
        $datoslogin = [
            'email' => '',
            'password' => '',
         ];

        $response = $this->call('POST', '/api/login', $datoslogin);
        $response->assertJsonFragment([
            "status" => false,
            "message" => "Error al validar datos",
        ]);
    }
}
