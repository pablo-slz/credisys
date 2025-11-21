<?php
// app/views/admin/revisar_creditos.php
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/sistema_pagos/public/css/style.css">
    <title>CrediSys - Revisar créditos</title>
</head>
<body>

<header class="header">
    <img src="../../public/img/logo.jpeg" alt="Logo CrediSys" class="logo-img">
    <div class="logo">CrediSys - Panel de Administración</div>

    <nav class="navbar">
      <ul>
        <li><a href="index.php?page=consultar_creditos">Consultar todos los créditos</a></li>
        <li><a href="index.php?page=revisar_creditos" class="active">Revisar solicitudes</a></li>
      </ul>
    </nav>

    <button class="logout-btn">
        <a href="index.php?page=logout">Cerrar sesión</a>
    </button>
</header>

<main class="container">
    <h2>Solicitudes de créditos pendientes</h2>

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
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($solicitudes)): ?>
                <?php foreach ($solicitudes as $solicitud): ?>
                    <tr>
                        <td><?= htmlspecialchars($solicitud['id_credito']) ?></td>
                        <td><?= htmlspecialchars($solicitud['nombre_usuario']) ?></td>
                        <td><?= htmlspecialchars($solicitud['fecha_creacion']) ?></td>
                        <td>$<?= number_format($solicitud['monto'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($solicitud['plazo']) ?> meses</td>
                        <td><?= htmlspecialchars($solicitud['descripcion']) ?></td>
                        <td><?= htmlspecialchars($solicitud['estado']) ?></td>
                        <td>
                            <a href="index.php?page=aprobar_solicitud&id=<?= $solicitud['id_credito'] ?>">Aprobar</a> |
                            <a href="index.php?page=rechazar_solicitud&id=<?= $solicitud['id_credito'] ?>">Rechazar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8">No hay solicitudes pendientes.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>
<script src="/sistema_pagos/public/js/app.js"></script>
</body>
</html>
