<?php
require_once "../config/db.php";
header('Content-Type: application/json');

$conn = Database::getConnection();

// Obtener todos los perros
function listarPerros($conn, $dni_cliente = null) {
    try {
        if ($dni_cliente) {
            $stmt = $conn->prepare("SELECT * FROM perros WHERE Dni_duenio = ?");
            $stmt->execute([$dni_cliente]);
        } else {
            $stmt = $conn->query("SELECT * FROM perros");
        }

        $perros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($perros)) {
            echo json_encode(["message" => "El cliente no tiene perros registrados"]);
        } else {
            echo json_encode($perros);
        }
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al obtener los perros: " . $e->getMessage()]);
    }
}

// Eliminar un perro por ID
function eliminarPerro($conn) {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (!isset($_DELETE['ID_Perro'])) {
        echo json_encode(["error" => "Falta el ID del perro"]);
        exit;
    }

    $ID_Perro = $_DELETE['ID_Perro'];
    try {
        $stmt = $conn->prepare("DELETE FROM perros WHERE ID_Perro = ?");
        $stmt->execute([$ID_Perro]);

        echo json_encode(["success" => "Perro eliminado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Insertar un nuevo perro
function insertarPerro($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['Dni_duenio'], $data['Nombre'], $data['Fecha_Nto'], $data['Raza'], $data['Peso'], $data['Altura'], $data['Numero_Chip'], $data['Sexo'])) {
        echo json_encode(["error" => "Faltan datos obligatorios"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO perros (Dni_duenio, Nombre, Fecha_Nto, Raza, Peso, Altura, Observaciones, Numero_Chip, Sexo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['Dni_duenio'],
            $data['Nombre'],
            $data['Fecha_Nto'],
            $data['Raza'],
            $data['Peso'],
            $data['Altura'],
            $data['Observaciones'] ?? null,
            $data['Numero_Chip'],
            $data['Sexo']
        ]);

        echo json_encode(["success" => "Perro agregado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al insertar perro: " . $e->getMessage()]);
    }
}

// Actualizar datos de un perro
function actualizarPerro($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['ID_Perro'], $data['Nombre'], $data['Peso'], $data['Altura'], $data['Observaciones'])) {
        echo json_encode(["error" => "Faltan datos obligatorios para actualizar"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE perros SET Nombre = ?, Peso = ?, Altura = ?, Observaciones = ? WHERE ID_Perro = ?");
        $stmt->execute([
            $data['Nombre'],
            $data['Peso'],
            $data['Altura'],
            $data['Observaciones'],
            $data['ID_Perro']
        ]);

        echo json_encode(["success" => "Perro actualizado correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error al actualizar perro: " . $e->getMessage()]);
    }
}

// Determinar qué función ejecutar
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['dni_cliente'])) {
            listarPerros($conn, $_GET['dni_cliente']);
        } else {
            listarPerros($conn);
        }
        break;
    case 'DELETE':
        eliminarPerro($conn);
        break;
    case 'POST':
        insertarPerro($conn);
        break;
    case 'PUT':
        actualizarPerro($conn);
        break;
    default:
        echo json_encode(["error" => "Método HTTP no permitido"]);
}
?>
