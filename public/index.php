<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';

$page = $_GET['page'] ?? 'login';

switch ($page) {

    case 'login':
        $authController = new AuthController();
        $error = $authController->login();
        include __DIR__ . '/../app/views/auth/login.php';
        break;

    case 'registro':
        include __DIR__ . '/../app/views/auth/registro.php';
        break;

    case 'guardar_usuario':
        $usuarioController = new UsuarioController();
        $usuarioController->guardar();
        break;

    // === ADMIN ===
    case 'consultar_creditos':
    require_once __DIR__ . '/../app/controllers/CreditoController.php';
    $controller = new CreditoController();

    // Captura del filtro (por defecto 'todos')
    $estado = $_GET['estado'] ?? 'todos';

    // Consultar los créditos (admin)
    $creditos = $controller->consultarCreditosAdmin($estado);

    // Cargar vista
    include __DIR__ . '/../app/views/admin/consultar_creditos.php';
    break;



    case 'revisar_creditos':
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_rol'] != 1) {
            header('Location: index.php?page=login');
            exit;
        }
        require_once __DIR__ . '/../app/controllers/CreditoController.php';
        $creditoController = new CreditoController();
        $solicitudes = $creditoController->revisarSolicitudes();
        include __DIR__ . '/../app/views/admin/revisar_creditos.php';
        break;

    case 'aprobar_solicitud':
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_rol'] != 1) {
            header('Location: index.php?page=login');
            exit;
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            require_once __DIR__ . '/../app/controllers/CreditoController.php';
            $creditoController = new CreditoController();
            $creditoController->actualizarEstado($id, 'aprobado');
        }
        break;

    case 'rechazar_solicitud':
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_rol'] != 1) {
            header('Location: index.php?page=login');
            exit;
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            require_once __DIR__ . '/../app/controllers/CreditoController.php';
            $creditoController = new CreditoController();
            $creditoController->actualizarEstado($id, 'rechazado');
        }
        break;

    // === CLIENTE ===
    case 'solicitar_credito':
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_rol'] != 2) {
            header('Location: index.php?page=login');
            exit;
        }
        include __DIR__ . '/../app/views/cliente/solicitar_credito.php';
        break;

    case 'guardar_credito':
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_rol'] != 2) {
            header('Location: index.php?page=login');
            exit;
        }
        require_once __DIR__ . '/../app/controllers/CreditoController.php';
        $creditoController = new CreditoController();
        $creditoController->solicitarCredito();
        break;

    case 'mis_solicitudes':
        require_once __DIR__ . '/../app/controllers/CreditoController.php';
        $controller = new CreditoController();
        $estado = $_GET['estado'] ?? 'todos';
        $mis_creditos = $controller->consultarCreditosCliente($_SESSION['usuario']['id_user'], $estado);
        include __DIR__ . '/../app/views/cliente/consultar_credito.php';
        break;


    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;

    default:
        header('Location: index.php?page=login');
        exit;
}
