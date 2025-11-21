<?php
require_once __DIR__ . '/../models/Credito.php';

class CreditoController {

    // Crear solicitud (cliente)
    public function solicitarCredito() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_user = $_SESSION['usuario']['id_user'] ?? null;

            if (!$id_user) {
                echo "❌ Error: No se encontró el usuario en la sesión.";
                exit;
            }

            $monto = $_POST['monto'] ?? null;
            $plazo = $_POST['plazo'] ?? null;
            $descripcion = $_POST['descripcion'] ?? '';

            if (!$monto || !$plazo) {
                echo "❌ Error: faltan datos (monto o plazo).";
                exit;
            }

            $credito = new Credito();
            if ($credito->crearCredito($id_user, $monto, $plazo, $descripcion)) {
                header("Location: index.php?page=mis_solicitudes");
                exit();
            } else {
                echo "❌ Error al registrar la solicitud de crédito.";
            }
        }
    }

    /**
     * Consultar créditos del cliente (con filtro opcional)
     */
    public function consultarCreditosCliente($id_user, $estado = 'todos') {
        $credito = new Credito();

        if ($estado && $estado !== 'todos') {
            // Usa el método que filtra por estado
            $creditos = $credito->obtenerCreditosClientePorEstado($id_user, $estado);
        } else {
            // Obtiene todos los créditos del cliente
            $creditos = $credito->obtenerCreditosCliente($id_user);
        }

        return $creditos;
    }

    /**
     * Revisar solicitudes pendientes (admin)
     */
    public function revisarSolicitudes() {
        $credito = new Credito();
        return $credito->obtenerSolicitudesPendientes();
    }

    /**
     * Consultar todos los créditos (admin) opcionalmente por estado
     */
    public function consultarTodos($estado = null) {
        $credito = new Credito();

        if ($estado && $estado !== 'todos') {
            return $credito->obtenerPorEstado($estado);
        }

        return $credito->obtenerTodos();
    }

    /**
     * Actualizar estado del crédito (admin)
     */
    public function actualizarEstado($id_credito, $estado) {
        $estado = strtolower($estado);
        if (!in_array($estado, ['aprobado', 'rechazado', 'pendiente'])) {
            echo "Estado no válido.";
            exit;
        }

        $credito = new Credito();
        if ($credito->actualizarEstado($id_credito, $estado)) {
            header("Location: index.php?page=revisar_creditos");
            exit();
        } else {
            echo "❌ Error al actualizar el estado.";
        }
    }
    public function consultarCreditosAdmin($estado = 'todos') {
    $credito = new Credito();
    return $estado === 'todos'
        ? $credito->obtenerTodos()
        : $credito->obtenerPorEstado($estado);
}

}
