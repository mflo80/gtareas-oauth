<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(20)->create();

        \App\Models\User::factory()->create([
             'nombre' => 'Juan',
             'apellido' => 'Pérez',
             'email' => 'juan.perez@example.com',
             'email_verified_at' => now(),
             'password' => Hash::make('123456'),
             'remember_token' => Str::random(30)
        ]);
    }
}
