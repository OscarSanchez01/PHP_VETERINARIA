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

// Insertar un nuevo servicio realizado
function agregarServicioRealizado($conn, $data){
    try {
        $stmt = $conn->prepare("INSERT INTO perro_recibe_servicio (Cod_Servicio, ID_Perro, Fecha, Incidencias, Precio_Final, Dni) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data['Cod_Servicio'], $data['ID_Perro'], $data['Fecha'], $data['Incidencias'], $data['Precio_Final'], $data['Dni']]);
        echo json_encode(["success" => "Servicio agregado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al agregar servicio: " . $e->getMessage()]);
    }
}

// Eliminar un servicio realizado
function eliminarServicioRealizado($conn, $sr_cod) {
    try {
        $stmt = $conn->prepare("DELETE FROM perro_recibe_servicio WHERE Sr_Cod = ?");
        $stmt->execute([$sr_cod]);
        echo json_encode(["success" => "Servicio eliminado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al eliminar servicio: " . $e->getMessage()]);
    }
}

// Modificar un servicio realizado
function actualizarServicioRealizado($conn)
{
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['Sr_Cod'], $data['Cod_Servicio'], $data['ID_Perro'], $data['Fecha'], $data['Incidencias'], $data['Precio_Final'], $data['Dni'])) {
        echo json_encode(["error" => "Faltan datos obligatorios para actualizar"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE perro_recibe_servicio SET Cod_Servicio = ?, ID_Perro = ?, Fecha = ?, Incidencias = ?, Precio_Final = ?, Dni = ? WHERE Sr_Cod = ?");
        $stmt->execute([
            $data['Cod_Servicio'],
            $data['ID_Perro'],
            $data['Fecha'],
            $data['Incidencias'],
            $data['Precio_Final'],
            $data['Dni'],
            $data['Sr_Cod']
        ]);

        echo json_encode(["success" => "Servicio realizado actualizado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al actualizar servicio: " . $e->getMessage()]);
    }
}

// Función listar servicios según el empleado seleccionado
function listarServiciosPorEmpleado($conn, $dni_empleado) {
    try {
        $stmt = $conn->prepare("SELECT * FROM perro_recibe_servicio WHERE Dni = ? ORDER BY Fecha DESC");
        $stmt->execute([$dni_empleado]);
        $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($servicios)) {
            echo json_encode(["message" => "El empleado no tiene servicios"]);
        } else {
            echo json_encode($servicios);
        }
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al obtener servicios del empleado: " . $e->getMessage()]);
    }
}

// Manejo de la API con switch
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['dni_empleado']) && !empty($_GET['dni_empleado'])) {
            listarServiciosPorEmpleado($conn, $_GET['dni_empleado']);
        } else {
            listarServiciosRealizados($conn);
        }
        break;
    case 'POST':
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        if ($data === null) {
            $data = $_POST;
        }

        agregarServicioRealizado($conn, $data);
        break;

    case 'PUT':
        actualizarServicioRealizado($conn);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        eliminarServicioRealizado($conn, $data['Sr_Cod']);
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
