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
function agregarServicioRealizado($conn, $data) {
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

// Manejo de la API con switch
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        listarServiciosRealizados($conn);
        break;

        case 'POST':
            $rawData = file_get_contents("php://input");
            
            // Si viene en JSON, decodificarlo
            $data = json_decode($rawData, true);
        
            // Si no es JSON, asumir que es un formulario normal
            if ($data === null) {
                $data = $_POST;
            }
        
            agregarServicioRealizado($conn, $data);
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
