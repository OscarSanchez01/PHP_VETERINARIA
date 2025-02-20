<?php
require_once "../config/db.php";
header('Content-Type: application/json');

$conn = Database::getConnection();

// Obtener todos los servicios
function obtenerServicios($conn) {
    try {
        $stmt = $conn->query("SELECT * FROM servicios");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Eliminar un servicio por Código
function eliminarServicio($conn) {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (!isset($_DELETE['codigo'])) {
        echo json_encode(["error" => "Falta el código del servicio"]);
        exit;
    }

    $codigo = $_DELETE['codigo'];
    try {
        $stmt = $conn->prepare("DELETE FROM servicios WHERE Codigo = ?");
        $stmt->execute([$codigo]);

        echo json_encode(["success" => "Servicio eliminado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Insertar un nuevo servicio
function insertarServicio($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['Codigo'], $data['Nombre'], $data['Precio'], $data['Descripcion'])) {
        echo json_encode(["error" => "Faltan datos obligatorios"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO servicios (Codigo, Nombre, Precio, Descripcion) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['Codigo'],
            $data['Nombre'],
            $data['Precio'],
            $data['Descripcion']
        ]);

        echo json_encode(["success" => "Servicio agregado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al insertar servicio: " . $e->getMessage()]);
    }
}

// Actualizar el precio de un servicio
function actualizarPrecioServicio($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['Codigo'], $data['Precio'])) {
        echo json_encode(["error" => "Faltan datos obligatorios"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE servicios SET Precio = ? WHERE Codigo = ?");
        $stmt->execute([
            $data['Precio'],
            $data['Codigo']
        ]);

        echo json_encode(["success" => "Precio actualizado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al actualizar precio: " . $e->getMessage()]);
    }
}

// Determinar qué función ejecutar
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        obtenerServicios($conn);
        break;
    case 'DELETE':
        eliminarServicio($conn);
        break;
    case 'POST':
        insertarServicio($conn);
        break;
    case 'PUT':
        actualizarPrecioServicio($conn);
        break;
    default:
        echo json_encode(["error" => "Método HTTP no permitido"]);
}
?>
