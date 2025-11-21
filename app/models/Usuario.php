<?php
require_once __DIR__ . '/../../config/database.php';

class Usuario {
    private $conn;
    private $table = "usuarios";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Crear usuario
    public function crear($nombre, $correo, $password, $tipo_rol) {
        $query = "INSERT INTO {$this->table} (nombre, correo, contraseña, tipo_rol) 
                  VALUES (:nombre, :correo, :contraseña, :tipo_rol)";
        $stmt = $this->conn->prepare($query);
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contraseña', $hash);
        $stmt->bindParam(':tipo_rol', $tipo_rol);

        return $stmt->execute();
    }

    // Buscar usuario por correo
    public function buscarPorCorreo($correo) {
        $query = "SELECT * FROM {$this->table} WHERE correo = :correo LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>