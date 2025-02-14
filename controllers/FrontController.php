<?php
class FrontController {
    public function handleRequest() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        
        switch ($page) {
            case 'insertCliente':
                require_once __DIR__ . '/../views/insertCliente.php';
                break;
            case 'insertPerro':
                require_once __DIR__ . '/../views/insertPerro.php';
                break;
            case 'insertEmpleado':
                require_once __DIR__ . '/../views/insertEmpleado.php';
                break;
            case 'insertServicio':
                require_once __DIR__ . '/../views/insertServicio.php';
                break;
            case 'insertPerroRecibe':
                require_once __DIR__ . '/../views/insertPerroRecibe.php';
                break;
            case 'listarServiciosEmpleado':
                require_once __DIR__ . '/../views/listarServiciosEmpleado.php';
                break;
            case 'listarTodosServicios':
                require_once __DIR__ . '/../views/listarTodosServicios.php';
                break;
            case 'listarClientePerros':
                require_once __DIR__ . '/../views/listarClientePerros.php';
                break;
            case 'modificarPrecio':
                require_once __DIR__ . '/../views/modificarPrecio.php';
                break;
            case 'login':
                require_once __DIR__ . '/../views/login.php';
                break;
            default:
                require_once __DIR__ . '/../views/home.php';
        }
    }
}
?>