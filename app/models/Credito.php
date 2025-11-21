<?php
require_once __DIR__ . '/../../config/database.php';

class Credito {
    private $conn;
    private $table_name = "creditos";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // 🔹 Crear solicitud de crédito
    public function crearCredito($id_user, $monto, $plazo, $descripcion) {
        $sql = "INSERT INTO {$this->table_name} (id_user, monto, plazo, descripcion, estado)
                VALUES (:id_user, :monto, :plazo, :descripcion, 'pendiente')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':plazo', $plazo);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    }

    // 🔹 Obtener todos los créditos de un cliente
    public function obtenerCreditosCliente($id_user) {
        $sql = "SELECT * FROM {$this->table_name} WHERE id_user = :id_user ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Obtener créditos del cliente filtrados por estado
    public function obtenerCreditosClientePorEstado($id_user, $estado) {
        $sql = "SELECT * FROM {$this->table_name} 
                WHERE id_user = :id_user AND estado = :estado 
                ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':estado', $estado);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Obtener solicitudes pendientes (vista admin)
    public function obtenerSolicitudesPendientes() {
        $sql = "SELECT c.*, u.nombre AS nombre_usuario
                FROM {$this->table_name} c
                INNER JOIN usuarios u ON c.id_user = u.id_user
                WHERE c.estado = 'pendiente'
                ORDER BY c.fecha_creacion DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Actualizar estado (aprobado / rechazado)
    public function actualizarEstado($id_credito, $estado) {
        $sql = "UPDATE {$this->table_name} 
                SET estado = :estado 
                WHERE id_credito = :id_credito";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_credito', $id_credito);
        return $stmt->execute();
    }

    // 🔹 Obtener todos los créditos (vista admin)
    public function obtenerTodos() {
        $sql = "SELECT c.*, u.nombre 
                FROM creditos c 
                JOIN usuarios u ON c.id_user = u.id_user
                ORDER BY c.fecha_creacion DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Obtener créditos filtrados por estado (para admin o cliente)
    public function obtenerPorEstado($estado, $id_user = null) {
        $sql = "SELECT c.*, u.nombre 
                FROM creditos c 
                JOIN usuarios u ON c.id_user = u.id_user 
                WHERE c.estado = :estado";

        // Si se pasa un usuario, filtra solo sus créditos (vista cliente)
        if ($id_user !== null) {
            $sql .= " AND c.id_user = :id_user";
        }

        $sql .= " ORDER BY c.fecha_creacion DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        if ($id_user !== null) {
            $stmt->bindParam(':id_user', $id_user);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
