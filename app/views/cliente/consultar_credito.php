<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../controllers/CreditoController.php';

$controller = new CreditoController();

$idCliente = $_SESSION['usuario']['id_user'] ?? null;
if (!$idCliente) {
    header("Location: index.php?page=login");
    exit;
}

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todos';

$creditos = $controller->consultarCreditosCliente($idCliente, $filtro);
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/sistema_pagos/public/css/style.css">
  <title>CrediSys - Consultar créditos</title>
</head>
<body>
  <header class="header">
    <img src="/sistema_pagos/public/img/logo.jpeg" alt="Logo CrediSys" class="login-logo">
    <div class="logo">CrediSys - Portal de Cliente</div>
    <nav class="navbar">
      <ul>
        <li><a href="index.php?page=solicitar_credito">Solicitar crédito</a></li>
        <li><a href="index.php?page=mis_solicitudes" class="active">Consultar créditos</a></li>
      </ul>
    </nav>
    <button class="logout-btn">
        <a href="index.php?page=logout">seguir en la sesion</a>
    </button>
  </header>

  <!-- CONTENIDO PRINCIPAL -->
  <main class="main-container">
    <section class="form-section">
      <h2>Mis créditos</h2>
  <!-- Filtro por estado -->
      <form method="GET" action="index.php" class="filter-form">
          <input type="hidden" name="page" value="mis_solicitudes">
          <label for="estado">Filtrar por estado:</label>
          <select name="estado" id="estado" onchange="this.form.submit()">
              <option value="todos" <?= (!isset($_GET['estado']) || $_GET['estado'] === 'todos') ? 'selected' : '' ?>>Todos</option>
              <option value="pendiente" <?= (isset($_GET['estado']) && $_GET['estado'] === 'pendiente') ? 'selected' : '' ?>>Pendientes</option>
              <option value="aprobado" <?= (isset($_GET['estado']) && $_GET['estado'] === 'aprobado') ? 'selected' : '' ?>>Aprobados</option>
              <option value="rechazado" <?= (isset($_GET['estado']) && $_GET['estado'] === 'rechazado') ? 'selected' : '' ?>>Rechazados</option>
          </select>
      </form>
      <table class="credits-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Monto</th>
            <th>Plazo</th>
            <th>Descripción</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($mis_creditos)): ?>
            <?php foreach ($mis_creditos as $credito): ?>
              <tr>
                <td><?= htmlspecialchars($credito['id_credito']) ?></td> 
                <td><?= htmlspecialchars($credito['fecha_creacion']) ?></td>
                <td>$<?= number_format($credito['monto'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($credito['plazo']) ?> meses</td>
                <td><?= htmlspecialchars($credito['descripcion']) ?></td>
                <td>
                  <?php 
                    $estado = strtolower($credito['estado']);
                    $clase_estado = match($estado) {
                      'aprobado' => 'aprobado',
                      'pendiente' => 'pendiente',
                      'rechazado' => 'rechazado',
                      default => ''
                    };
                  ?>
                  <span class="status <?= $clase_estado ?>"><?= htmlspecialchars($credito['estado']) ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="6">No tienes créditos registrados.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </main>
  <script src="/sistema_pagos/public/js/app.js"></script>
</body>
</html>
