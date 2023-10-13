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
        <br>
		<p>Has solicitado restablecer la contraseña de tu cuenta de Gestor de Tareas. Para continuar con dicho proceso,</p>
        <p>ingresa al siguiente Link -> <a href='{{getenv('LINK_RESTABLECER_PASSWORD')}}{{$mailData['token']}}'>Acceso a Restablecer Contraseña</a></p>
        <br>
        <p>Es de acotar que, el plazo máximo para restablecer la contraseña es de 15 minutos, trascurrido dicho tiempo, deberá de solicitar</p>
        <p>nuevamente el restablecimiento de la contraseña, a fin de que le llegue un nuevo correo con un Link de acceso vigente.</p>
        <br>
        <p>Saluda atentamente</p>
        <p>El equipo de Gestor de Tareas</p>
    </body>
</html>

