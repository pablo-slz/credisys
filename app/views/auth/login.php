<?php
$error = $error ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/sistema_pagos/public/css/style.css">
    <title>CrediSys - Login</title>
</head>
<body>
<div class="login-container">
    <img src="/sistema_pagos/public/img/logos.png" alt="Logo CrediSys" class="login-logo">
    
    <h2>CrediSys</h2>
    <p>Sistema de Gestión de Créditos</p>

    <form method="POST" action="index.php?page=login">
        <label for="correo">Correo</label>
        <input type="text" id="correo" name="correo" placeholder="Correo" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Iniciar sesión</button>
    </form>

    <?php if($error != ''): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</div>
<script src="/sistema_pagos/public/js/app.js"></script>
</body>
</html>
