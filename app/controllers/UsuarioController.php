<?php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $rol = $_POST['id_rol'];    

            $usuario = new Usuario();

            // Verificar si ya existe el correo
            $existe = $usuario->buscarPorEmail($email);
            if ($existe) {
                $error = "El correo ya está registrado.";
                include '../app/views/registro.php';
                return;
            }

            // Guardar usuario
            $guardado = $usuario->crear($nombre, $email, $password, $rol);

            if ($guardado) {
                header("Location: index.php?page=login");
                exit;
            } else {
                $error = "Error al registrar el usuario.";
                include '../app/views/registro.php';
            }
        } else {
            include '../app/views/registro.php';
        }
    }
}
