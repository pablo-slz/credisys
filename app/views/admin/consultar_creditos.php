<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar que el usuario haya iniciado sesión y sea admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_rol'] != 1) {
    header('Location: index.php?page=login');
    exit;
}

require_once __DIR__ . '/../../controllers/CreditoController.php';
$controller = new CreditoController();

// Obtener el estado filtrado desde la URL (GET)
$estado = $_GET['estado'] ?? 'todos';

// Cargar los créditos según el filtro
$creditos = $controller->consultarCreditosAdmin($estado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/sistema_pagos/public/css/style.css">
  <title>CrediSys - Panel de Administración</title>
</head>
<body>

<header class="header">
    <img src="/sistema_pagos/public/img/logo.jpeg" alt="Logo CrediSys" class="login-logo">
    <div class="logo">CrediSys - Panel de Administración</div>

    <nav class="navbar">
      <ul>
        <li><a href="index.php?page=consultar_creditos" class="active">Consultar todos los créditos</a></li>
        <li><a href="index.php?page=revisar_creditos">Revisar solicitudes</a></li>

      </ul>
    </nav>

    <button class="logout-btn">
      <a href="index.php?page=logout">Cerrar sesión</a>
    </button>
</header>

<main class="container">
  <h2>Todos los créditos</h2>
<!-- Filtro por estado -->
    <form method="GET" action="index.php" class="filter-form">
        <input type="hidden" name="page" value="consultar_creditos">
        <label for="estado">Filtrar por estado:</label>
        <select name="estado" id="estado" onchange="this.form.submit()">
            <option value="todos" <?= (!isset($_GET['estado']) || $_GET['estado'] === 'todos') ? 'selected' : '' ?>>Todos</option>
            <option value="pendiente" <?= (isset($_GET['estado']) && $_GET['estado'] === 'pendiente') ? 'selected' : '' ?>>Pendientes</option>
            <option value="aprobado" <?= (isset($_GET['estado']) && $_GET['estado'] === 'aprobado') ? 'selected' : '' ?>>Aprobados</option>
            <option value="rechazado" <?= (isset($_GET['estado']) && $_GET['estado'] === 'rechazado') ? 'selected' : '' ?>>Rechazados</option>
        </select>
    </form>
  <table border="1" cellspacing="0" cellpadding="5">
    <thead>
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Fecha</th>
        <th>Monto</th>
        <th>Plazo</th>
        <th>Descripción</th>
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($creditos)): ?>
        <?php foreach ($creditos as $credito): ?>
          <tr>
            <td><?= htmlspecialchars($credito['id_credito']) ?></td>
            <td><?= htmlspecialchars($credito['nombre']) ?></td>
            <td><?= htmlspecialchars($credito['fecha_creacion']) ?></td>
            <td>$<?= number_format($credito['monto'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($credito['plazo']) ?> meses</td>
            <td><?= htmlspecialchars($credito['descripcion']) ?></td>
            <td><?= htmlspecialchars($credito['estado']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="7">No se encontraron créditos registrados.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>
<script src="/sistema_pagos/public/js/app.js"></script>
</body>
</html>
