<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestor de Tareas</title>
    </head>
    <body>
        <h3>{{ $mailData['title'] }}</h3>
        <br>
        <p>{{ $mailData['body'] }}</p>
        <p>Gracias por registrarte en Gestor de Tareas. Para poder utilizar tu cuenta, primero debes de confirmarla haciendo clic en el siguiente enlace.</p>
        <p>Haz clic aquí -> <a href='{{getenv('LINK_RESTABLECER_PASSWORD')}}{{$mailData['token']}}'>Restablecer Contraseña</a></p>
        <br>
        <p>Saluda atentamente</p>
        <p>El equipo de Gestor de Tareas</p>
    </body>
</html>

