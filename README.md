# gtareas-oauth

Proyecto Gestor de Tareas / TA2 - Programación II

El presente contiene el código del Oauth Authentication API (creado con Laravel).

Herramientas utilizadas para realizar el mismo:
- Docker / Compose
- Laravel 10
- PHP 8.2
- MySQL 8.1

El código del resto de los contenedores se encuentra mencionado en:
- https://github.com/mflo80/gtareas-docker

<br>
Observaciones:
<br><br>
Se debe de instalar Laravel Passport, por lo que se deberá de seguir los siguientes pasos:
<br>

- composer require laravel/passport
- php artisan migrate
- php artisan passport:install

Para generar las keys en Passport:

- php artisan passport:keys
- php artisan passport:client --password
