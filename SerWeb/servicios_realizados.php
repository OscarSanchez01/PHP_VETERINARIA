<?php
require_once "../config/db.php";
header('Content-Type: application/json');

$conn = Database::getConnection();

// Listar todos los servicios realizados
function listarServiciosRealizados($conn) {
    try {
        $stmt = $conn->query("SELECT * FROM perro_recibe_servicio");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al obtener servicios realizados: " . $e->getMessage()]);
    }
}

// Listar servicios realizados por un empleado específico
function listarServiciosPorEmpleado($conn, $dni_empleado) {
    try {
        $stmt = $conn->prepare("SELECT * FROM perro_recibe_servicio WHERE Dni = ?");
        $stmt->execute([$dni_empleado]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al obtener servicios del empleado: " . $e->getMessage()]);
    }
}

// Registrar un servicio realizado
function registrarServicioRealizado($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['Fecha'], $data['Cod_Servicio'], $data['ID_Perro'], $data['Dni'], $data['Precio_Final'])) {
        echo json_encode(["error" => "Faltan datos obligatorios"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO perro_recibe_servicio (Fecha, Cod_Servicio, ID_Perro, Dni, Precio_Final, Incidencias) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['Fecha'],
            $data['Cod_Servicio'],
            $data['ID_Perro'],
            $data['Dni'],
            $data['Precio_Final'],
            $data['Incidencias'] ?? null
        ]);

        echo json_encode(["success" => "Servicio registrado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al registrar servicio: " . $e->getMessage()]);
    }
}

// Eliminar un servicio realizado
function eliminarServicioRealizado($conn) {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (!isset($_DELETE['Sr_Cod'])) {
        echo json_encode(["error" => "Falta el código del servicio realizado"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("DELETE FROM perro_recibe_servicio WHERE Sr_Cod = ?");
        $stmt->execute([$_DELETE['Sr_Cod']]);

        echo json_encode(["success" => "Servicio eliminado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al eliminar servicio: " . $e->getMessage()]);
    }
}

// Determinar qué función ejecutar con switch-case
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['dni_empleado'])) {
            listarServiciosPorEmpleado($conn, $_GET['dni_empleado']);
        } else {
            listarServiciosRealizados($conn);
        }
        break;
    case 'POST':
        registrarServicioRealizado($conn);
        break;
    case 'DELETE':
        eliminarServicioRealizado($conn);
        break;
    default:
        echo json_encode(["error" => "Método HTTP no permitido"]);
}
?>
