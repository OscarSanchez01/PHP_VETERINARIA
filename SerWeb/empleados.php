<?php
require_once "../config/db.php";
header('Content-Type: application/json');

$conn = Database::getConnection();

// Obtener todos los empleados
function obtenerEmpleados($conn) {
    try {
        $stmt = $conn->query("SELECT * FROM empleados");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Eliminar un empleado por DNI
function eliminarEmpleado($conn) {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (!isset($_DELETE['dni'])) {
        echo json_encode(["error" => "Falta el DNI del empleado"]);
        exit;
    }

    $dni = $_DELETE['dni'];
    try {
        $stmt = $conn->prepare("DELETE FROM empleados WHERE Dni = ?");
        $stmt->execute([$dni]);

        echo json_encode(["success" => "Empleado eliminado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Insertar un nuevo empleado
function insertarEmpleado($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['Dni'], $data['Email'], $data['Password'], $data['Rol'], $data['Nombre'], $data['Tlfno'])) {
        echo json_encode(["error" => "Faltan datos obligatorios"]);
        exit;
    }

    $hashedPassword = password_hash($data['Password'], PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO empleados (Dni, Email, Password, Rol, Nombre, Apellido1, Apellido2, Calle, Numero, Cp, Poblacion, Provincia, Tlfno, Profesion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['Dni'],
            $data['Email'],
            $hashedPassword,
            $data['Rol'],
            $data['Nombre'],
            $data['Apellido1'] ?? null,
            $data['Apellido2'] ?? null,
            $data['Calle'] ?? null,
            $data['Numero'] ?? null,
            $data['Cp'] ?? null,
            $data['Poblacion'] ?? null,
            $data['Provincia'] ?? null,
            $data['Tlfno'],
            $data['Profesion'] ?? null
        ]);

        echo json_encode(["success" => "Empleado agregado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al insertar empleado: " . $e->getMessage()]);
    }
}

// Actualizar datos de un empleado
function actualizarEmpleado($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['Dni'], $data['Email'], $data['Rol'], $data['Nombre'], $data['Tlfno'])) {
        echo json_encode(["error" => "Faltan datos obligatorios para actualizar"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE empleados SET Email = ?, Rol = ?, Nombre = ?, Apellido1 = ?, Apellido2 = ?, Calle = ?, Numero = ?, Cp = ?, Poblacion = ?, Provincia = ?, Tlfno = ?, Profesion = ? WHERE Dni = ?");
        $stmt->execute([
            $data['Email'],
            $data['Rol'],
            $data['Nombre'],
            $data['Apellido1'] ?? null,
            $data['Apellido2'] ?? null,
            $data['Calle'] ?? null,
            $data['Numero'] ?? null,
            $data['Cp'] ?? null,
            $data['Poblacion'] ?? null,
            $data['Provincia'] ?? null,
            $data['Tlfno'],
            $data['Profesion'] ?? null,
            $data['Dni']
        ]);

        echo json_encode(["success" => "Empleado actualizado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al actualizar empleado: " . $e->getMessage()]);
    }
}

// Determinar qué función ejecutar
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        obtenerEmpleados($conn);
        break;
    case 'DELETE':
        eliminarEmpleado($conn);
        break;
    case 'POST':
        insertarEmpleado($conn);
        break;
    case 'PUT':
        actualizarEmpleado($conn);
        break;
    default:
        echo json_encode(["error" => "Método HTTP no permitido"]);
}
?>
