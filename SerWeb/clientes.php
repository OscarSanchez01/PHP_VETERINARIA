<?php
require_once "../config/db.php";
header('Content-Type: application/json');

$conn = Database::getConnection();

// Obtener todos los clientes
function obtenerClientes($conn)
{
    try {
        $stmt = $conn->query("SELECT * FROM clientes");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Eliminar un cliente por DNI
function eliminarCliente($conn)
{
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (!isset($_DELETE['dni'])) {
        echo json_encode(["error" => "Falta el DNI del cliente"]);
        exit;
    }

    $dni = $_DELETE['dni'];
    try {
        $stmt = $conn->prepare("DELETE FROM clientes WHERE Dni = ?");
        $stmt->execute([$dni]);

        echo json_encode(["success" => "Cliente eliminado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Insertar un nuevo cliente
function insertarCliente($conn)
{
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['Dni'], $data['Nombre'], $data['Apellido1'], $data['Direccion'], $data['Tlfno'])) {
        echo json_encode(["error" => "Faltan datos obligatorios"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO clientes (Dni, Nombre, Apellido1, Apellido2, Direccion, Tlfno) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['Dni'],
            $data['Nombre'],
            $data['Apellido1'],
            $data['Apellido2'] ?? null,
            $data['Direccion'],
            $data['Tlfno']
        ]);

        echo json_encode(["success" => "Cliente agregado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al insertar cliente: " . $e->getMessage()]);
    }
}

// Actualizar un cliente
function actualizarCliente($conn)
{
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['Dni'], $data['Nombre'], $data['Apellido1'], $data['Direccion'], $data['Tlfno'])) {
        echo json_encode(["error" => "Faltan datos obligatorios para actualizar"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE clientes SET Nombre = ?, Apellido1 = ?, Apellido2 = ?, Direccion = ?, Tlfno = ? WHERE Dni = ?");
        $stmt->execute([
            $data['Nombre'],
            $data['Apellido1'],
            $data['Apellido2'] ?? null,
            $data['Direccion'],
            $data['Tlfno'],
            $data['Dni']
        ]);

        echo json_encode(["success" => "Cliente actualizado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al actualizar cliente: " . $e->getMessage()]);
    }
}

// Determinar qué función ejecutar
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        obtenerClientes($conn);
        break;
    case 'DELETE':
        eliminarCliente($conn);
        break;
    case 'POST':
        insertarCliente($conn);
        break;
    case 'PUT':
        actualizarCliente($conn);
        break;
    default:
        echo json_encode(["error" => "Método HTTP no permitido"]);
}
