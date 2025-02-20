<?php
require_once "../config/db.php";
header('Content-Type: application/json');

$conn = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $conn->query("SELECT * FROM perro_recibe_servicio");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}
?>
