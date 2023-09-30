<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login_correcto()
    {
        $response = $this->json('POST', 'api/login', [
            'email' => 'juan.perez@example.com',
            'password' => '123456',
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(Auth::check());
        $response->assertJsonFragment([
            "status" => true,
            "message" => "Sesión iniciada correctamente"
        ]);
    }

    public function test_login_incorrecto()
    {
        $response = $this->json('POST', 'api/login', [
            'email' => 'juan.perez@example.com',
            'password' => '1234567',
        ]);

        $response->assertStatus(401)
            ->assertJsonFragment([
                "status" => false,
                "message" => "Correo y/o contraseña incorrectos."
            ]);
    }

    public function test_login_sin_cargar_datos()
    {
        $response = $this->json('POST', 'api/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(401)
            ->assertJsonFragment([
                "status" => false,
                "message" => "Error al validar datos",
            ]);
    }

    public function test_logout()
    {
        $response = $this->json('GET', 'api/logout', []);
        $response->assertStatus(200)
            ->assertJsonFragment([
               "status" => true,
               'message' => 'Se ha cerrado la sesión con éxito.'
            ]);
    }

    public function test_logout_no_autenticado()
    {
        $response = $this->json('GET', 'api/logout', []);
        $response->assertStatus(401)
            ->assertSee('Unauthenticated');;
    }
}
