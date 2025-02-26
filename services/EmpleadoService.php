<?php
require_once "../config/db.php";
class EmpleadoService {
    private static $api_url = "http://localhost/PHP_VETERINARIA/SerWeb/empleados.php";

    public static function getEmpleados() {
        return json_decode(file_get_contents(self::$api_url), true);
    }

    public static function existeEmpleado($dni) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM empleados WHERE Dni = ?");
        $stmt->execute([$dni]);
        return $stmt->fetchColumn() > 0;
    }

    public static function crearEmpleado($dni, $email, $password, $rol, $nombre, $apellido1, $apellido2, $calle, $numero, $cp, $poblacion, $provincia, $tlfno, $profesion) {
        $data = [
            "Dni" => $dni,
            "Email" => $email,
            "Password" => $password,
            "Rol" => $rol,
            "Nombre" => $nombre,
            "Apellido1" => $apellido1,
            "Apellido2" => $apellido2,
            "Calle" => $calle,
            "Numero" => $numero,
            "Cp" => $cp,
            "Poblacion" => $poblacion,
            "Provincia" => $provincia,
            "Tlfno" => $tlfno,
            "Profesion" => $profesion
        ];
        return self::postRequest($data);
    }

    public static function actualizarEmpleado($dni, $email, $rol, $nombre, $apellido1, $apellido2, $tlfno, $profesion) {
        $data = [
            "Dni" => $dni,
            "Email" => $email,
            "Rol" => $rol,
            "Nombre" => $nombre,
            "Apellido1" => $apellido1,
            "Apellido2" => $apellido2,
            "Tlfno" => $tlfno,
            "Profesion" => $profesion
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

    
}
?>
