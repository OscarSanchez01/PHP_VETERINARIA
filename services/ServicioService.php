<?php
require_once "../config/db.php";
class ServicioService {
    private static $api_url = "http://localhost/PHP_VETERINARIA/SerWeb/servicios.php";

    public static function getServicios() {
        return json_decode(file_get_contents(self::$api_url), true);
    }
    
    public static function existeServicio($codServicio) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM servicios WHERE Cod_Servicio = ?");
        $stmt->execute([$codServicio]);
        return $stmt->fetchColumn() > 0; 
    }

    public static function crearServicio($codigo, $nombre, $precio, $descripcion) {
        $data = [
            "Codigo" => $codigo,
            "Nombre" => $nombre,
            "Precio" => $precio,
            "Descripcion" => $descripcion
        ];
        return self::postRequest($data);
    }

    public static function actualizarPrecioServicio($codigo, $precio) {
        $data = [
            "Codigo" => $codigo,
            "Precio" => $precio
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

       // Eliminar un servicio realizado
       public static function deleteServicio($codigo) {
            $options = [
                'http' => [
                    'method'  => 'DELETE',
                    'content' => http_build_query(['codigo' => $codigo])
                ]
            ];
            $context = stream_context_create($options);
            $response = file_get_contents(self::$api_url, false, $context);
            return json_decode($response, true);
        }
}
?>
