<?php
// app/views/auth/registro.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="registro-container">
        <div class="login-logo"></div>
        <h2>Crear Cuenta</h2>
        <p>Completa tus datos para registrarte</p>

        <form action="index.php?page=guardar_usuario" method="POST" class="formulario">

            <label for="nombre">Nombre completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" required>

            <label for="celular">Celular:</label>
            <input type="text" id="celular" name="celular" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="id_rol">Rol:</label>
            <select id="id_rol" name="id_rol" required>
                <option value="">Selecciona un rol</option>
                <option value="1">Administrador</option>
                <option value="2">Cliente</option>
            </select>

            <button type="submit">Registrarme</button>
        </form>

        <p class="enlace">¿Ya tienes cuenta? <a href="index.php?page=login">Inicia sesión</a></p>
    </div>
</body>
</html>
