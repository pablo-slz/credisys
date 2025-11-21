<?php
// app/views/cliente/solicitar_credito.php

// Asegurarse de que el usuario sea cliente
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_rol'] != 2) {
    header('Location: index.php?page=login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/sistema_pagos/public/css/style.css">
  <title>CrediSys - Solicitar crédito</title>
</head>
<body>
  <header class="header">
    <img src="../../public/img/logos.png" alt="Logo CrediSys" class="logo-img">
    <div class="logo">CrediSys - Portal de Cliente</div>
    <nav class="navbar">
      <ul>
        <li><a href="index.php?page=solicitar_credito" class="active">Solicitar crédito</a></li>
        <li><a href="index.php?page=mis_solicitudes">Consultar créditos</a></li>
      </ul>
    </nav>
    <button class="logout-btn">
        <a href="index.php?page=logout">Cerrar sesión</a>
    </button>
  </header>

  <main class="main-container">
    <section class="form-section">  
      <h2>Nueva solicitud de crédito</h2>
      <form class="credit-form" method="POST" action="index.php?page=guardar_credito">
        <div class="form-group">
          <label for="monto">Monto solicitado</label>
          <input type="number" id="monto" name="monto" placeholder="Ej: 5000" required />
        </div>

        <div class="form-group">
          <label for="plazo">Plazo (meses)</label>
          <input type="number" id="plazo" name="plazo" placeholder="Ej: 12" required />
        </div>

        <div class="form-group">
          <label for="descripcion">Descripción</label>
          <textarea id="descripcion" name="descripcion" placeholder="Motivo del crédito" required></textarea>
        </div>

        <button type="submit" class="btn-primary">Enviar solicitud</button>
      </form>
    </section>
  </main>
  <script src="/sistema_pagos/public/js/app.js"></script>
</body>
</html>
