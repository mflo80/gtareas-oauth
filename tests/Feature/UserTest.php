<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_registrar_usuario()
    {
        $datos = [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'jperez@prueba.com',
            'password' => '123456'
        ];

        $response = $this->postJson('api/usuarios', $datos);
        $response->assertStatus(200)
        ->assertJsonFragment([
            'status' => true,
            'message' => 'Registro correcto, confirme su correo.'
        ]);
    }

  /*  public function test_registrar_usuario_error_email_registrado()
    {
        $datos = [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'jperez@prueba.com',
            'password' => '123456'
        ];

        $response = $this->postJson('api/usuarios', $datos);
        $response->assertStatus(500)
        ->assertJsonFragment([
            'status' => false,
            'message' => 'Registro correcto, confirme su correo.'
        ]);
    }*/

    public function test_buscar_usuarios()
    {
        $response = $this->getJson('api/usuarios');
        $response->assertStatus(200)
        ->assertJsonFragment([
            'status' => true,
            'message' => 'Usuarios encontrados.'
        ]);
    }

    public function test_buscar_usuario_id()
    {
        $response = $this->getJson('api/usuarios/1');
        $response->assertStatus(200)
        ->assertJsonFragment([
            'status' => true,
            'message' => 'Usuario encontrado.'
        ]);
    }

    public function test_buscar_usuario_id_inexistente()
    {
        $response = $this->getJson('api/usuarios/100');
        $response->assertStatus(404)
        ->assertJsonFragment([
            'status' => true,
            'message' => 'Usuario no encontrado.'
        ]);
    }
}
