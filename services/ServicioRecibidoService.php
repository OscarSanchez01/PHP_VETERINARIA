<?php
class ServicioRecibidoService {
    private static $api_url = "http://localhost/gromer/SerWeb/servicios_recibidos.php";

    public static function getServiciosRecibidos() {
        $response = file_get_contents(self::$api_url);
        return json_decode($response, true);
    }
}
?>
