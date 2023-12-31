<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    protected $token;

    public function test_login_correcto()
    {
        global $token;

        $datos = [
            "email" => "juan.perez@gtareas.com",
            "password" => "123456"
        ];

        $response = $this->postJson('api/auth/login', $datos);

        $datos = $response->json();
        $token = $datos['token'];

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(Auth::check());

        $response->assertJsonFragment([
            "status" => true,
            "message" => "Sesión iniciada correctamente"
        ]);
    }

    public function test_login_incorrecto()
    {
        $datos = [
            "email" => "juan.perez@example.com",
            "password" => "1234567"
        ];

        $response = $this->postJson('api/auth/login', $datos);

        $response->assertStatus(401)
            ->assertJsonFragment([
                "status" => false,
                "message" => "Correo y/o contraseña incorrectos."
            ]);
    }

    public function test_logout_correcto()
    {
        global $token;

        $header = [
            "Authorization" => "Bearer " .  $token
        ];

        $response = $this->getJson('api/auth/logout', $header);
        $token = null;

        $response->assertStatus(200)
            ->assertJsonFragment([
               "status" => true,
               "message" => "Sesión cerrada correctamente."
            ]);
    }

    public function test_logout_no_autenticado()
    {
        $response = $this->getJson('api/auth/logout', []);
        $response->assertStatus(401)
            ->assertSee('Unauthenticated');;
    }

    public function test_logout_token_incorrecto()
    {
        $token = "99|cRrJlyFSWCoZSVn9ZimNIQb3s3AwiAt35dd6udcI747495cc-copia";
        $header = [
            "Authorization" => "Bearer " .  $token
        ];

        $response = $this->getJson('api/auth/logout', $header);

        $response->assertStatus(401)
            ->assertSee('Unauthenticated');;
    }
}
