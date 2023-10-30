<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Gestor de Tareas</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 1.2rem;
        line-height: 1.5;
    }

    h3 {
        font-size: 1.4rem;
        font-weight: bold;
    }

    p {
        margin: 0 0 1em;
    }

    .logo {
        display: block;
        margin: 1em 0;
        max-width: 100%;
        width: 16rem;
        text-align: left;
    }

    a {
        flex: 1;
        text-decoration: none;
        outline: none;
        text-align: center;
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 0.6rem 1rem;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: auto;
        margin: 0.25rem 0.5rem;
        cursor: pointer;
        border-radius: 0.3rem;
        width: 16rem;
        height: 1.8rem;
        word-wrap: break-word;
    }

    a:link,
    a:visited,
    a:focus {
        background-color: #008CBA;
        color: white;
    }

    a:hover {
        background: orange;
    }

    a:active {
        background: darkred;
        color: white;
    }

    .saludo {
        line-height: 0.5;
    }
</style>

<body>
    <h3>{{ $mailData['titulo'] }}</h3>
    <br>
    <p>{{ $mailData['subtitulo'] }}</p>
    <br>
    <p>Has solicitado restablecer la contraseña de tu cuenta de Gestor de Tareas. Para continuar con dicho proceso,
        ingresa al siguiente Link:</p>
    <a href='{{ getenv('SERVER_RESTABLECER_PASSWORD') }}/password-{{ $mailData['token'] }}' target="_blank">Restablecer Contraseña</a>
    <br><br>
    <p>Es de acotar que, el plazo máximo para restablecer la contraseña es de 15 minutos, trascurrido dicho tiempo, deberá de
       solicitar nuevamente el restablecimiento de la contraseña, a fin de que le llegue un nuevo correo con un Link de acceso vigente.</p>
    <br>
    <div class="saludo">
        <p>Saluda atentamente</p>
        <p>El equipo de Gestor de Tareas</p>
        <img class="logo" src="https://raw.githubusercontent.com/mflo80/gtareas-login/main/public/img/logo.png"
            width="200px" alt="LOGO" />
    </div>
</body>

</html>
