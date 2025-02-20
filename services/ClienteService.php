<?php
class ClienteService {
    private static $api_url = "http://localhost/gromer/SerWeb/clientes.php";

    public static function getClientes() {
        return json_decode(file_get_contents(self::$api_url), true);
    }

    public static function crearCliente($dni, $nombre, $apellido1, $apellido2, $direccion, $tlfno) {
        $data = [
            "Dni" => $dni,
            "Nombre" => $nombre,
            "Apellido1" => $apellido1,
            "Apellido2" => $apellido2,
            "Direccion" => $direccion,
            "Tlfno" => $tlfno
        ];
        return self::postRequest($data);
    }

    public static function actualizarCliente($dni, $nombre, $apellido1, $apellido2, $direccion, $tlfno) {
        $data = [
            "Dni" => $dni,
            "Nombre" => $nombre,
            "Apellido1" => $apellido1,
            "Apellido2" => $apellido2,
            "Direccion" => $direccion,
            "Tlfno" => $tlfno
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
