<?php
require_once "../config/db.php";
session_start();
header('Content-Type: application/json');

class LoginController {
    public static function login($email, $password) {
        $conn = Database::getConnection();

        try {
            $stmt = $conn->prepare("SELECT * FROM empleados WHERE Email = ?");
            $stmt->execute([$email]);
            $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($empleado && password_verify($password, $empleado['Password'])) {
                // Guardar datos en la sesión
                $_SESSION['user_id'] = $empleado['Dni'];
                $_SESSION['user_email'] = $empleado['Email']; 
                $_SESSION['user_role'] = $empleado['Rol'];
                $_SESSION['user_profesion'] = $empleado ['Profesion'];

                return [
                    "success" => "Inicio de sesión exitoso",
                    "email" => $empleado['Email'],
                    "role" => $empleado['Rol'],
                    "profesion" => $empleado['Profesion']
                ];
            } else {
                return ["error" => "Credenciales incorrectas"];
            }
        } catch (Exception $e) {
            return ["error" => "Error en la autenticación: " . $e->getMessage()];
        }
    }

    public static function logout() {
        session_destroy();
        return ["success" => "Sesión cerrada"];
    }
}

// Si la petición viene desde el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['email'], $data['password'])) {
        echo json_encode(["error" => "Faltan datos obligatorios"]);
        exit;
    }

    echo json_encode(LoginController::login($data['email'], $data['password']));
}

// Si la petición es para cerrar sesión
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['logout'])) {
    echo json_encode(LoginController::logout());
}
?>
