<?php
require_once "../config/db.php";
class PerroService {
    private static $api_url = "http://localhost/PHP_VETERINARIA/SerWeb/perros.php";

    public static function getPerros() {
        $response = file_get_contents(self::$api_url);
        $perros = json_decode($response, true);
        
        return is_array($perros) ? $perros : [];
    }

    public static function existePerro($idPerro) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM perros WHERE ID_Perro = ?");
        $stmt->execute([$idPerro]);
        return $stmt->fetchColumn() > 0;
    }

    public static function crearPerro($dni_duenio, $nombre, $fecha_nacimiento, $raza, $peso, $altura, $observaciones, $numero_chip, $sexo) {
        $data = [
            "Dni_duenio" => $dni_duenio,
            "Nombre" => $nombre,
            "Fecha_Nto" => $fecha_nacimiento,
            "Raza" => $raza,
            "Peso" => $peso,
            "Altura" => $altura,
            "Observaciones" => $observaciones,
            "Numero_Chip" => $numero_chip,
            "Sexo" => $sexo
        ];
        return self::postRequest($data);
    }

    public static function actualizarPerro($id_perro, $nombre, $raza, $fecha_nacimiento, $peso, $altura, $observaciones, $numero_chip, $sexo, $dni_duenio) {
        $data = [
            "ID_Perro" => $id_perro,
            "Nombre" => $nombre,
            "Raza" => $raza,
            "Fecha_Nto" => $fecha_nacimiento,
            "Peso" => $peso,
            "Altura" => $altura,
            "Observaciones" => $observaciones,
            "Numero_Chip" => $numero_chip,
            "Sexo" => $sexo,
            "Dni_duenio" => $dni_duenio
        ];
        return self::putRequest($data);
    }
    

    private static function postRequest($data) {
        return self::sendRequest($data, "POST");
    }

    private static function putRequest($data) {
        return self::sendRequest($data, "PUT");
    }

    private static function sendRequest($data, $method) {
        $ch = curl_init(self::$api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    public static function getPerrosPorCliente($dni_cliente) {
        $url = self::$api_url . "?dni_cliente=" . urlencode($dni_cliente);
        $response = file_get_contents($url);

        // Manejar errores en la respuesta
        if ($response === false) {
            return [];
        }

        $perros = json_decode($response, true);
        return is_array($perros) ? $perros : [];
    }

    // Eliminar un servicio realizado
    public static function deletePerro($ID_Perro) {
        $options = [
            'http' => [
                'method'  => 'DELETE',
                'content' => http_build_query(['ID_Perro' => $ID_Perro])
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents(self::$api_url, false, $context);
        return json_decode($response, true);
    }
}
?>
