<?php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $correo = $_POST['correo'] ?? '';
        $password = $_POST['password'] ?? '';

        $usuarioModel = new Usuario();
        $user = $usuarioModel->buscarPorCorreo($correo);

        if ($user && isset($user['password'])) {
            $hash = $user['password'];

            $loginCorrecto = str_starts_with($hash, '$2y$') 
                ? password_verify($password, $hash) 
                : ($password === $hash);

            if ($loginCorrecto) {
                $_SESSION['usuario'] = [
                    'id_user' => $user['id_user'],
                    'nombre' => $user['nombre'],
                    'tipo_rol' => $user['tipo_rol']
                ];

                if ($user['tipo_rol'] == 1) {
                    header("Location: index.php?page=consultar_creditos");
                } else {
                    header("Location: index.php?page=solicitar_credito");
                }
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos";
            }
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    }

    // **Importante:** devolver $error para que el index lo reciba
    return $error;
}


    /**
     * Logout de usuario
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
?>
