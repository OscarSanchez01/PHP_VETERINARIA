<?php
class ServicioRealizadoService {
    private static $api_url = "http://localhost/gromer/SerWeb/servicios_recibidos.php";

    // Obtener los servicios según el rol del usuario
    public static function getServicios($dni_empleado = null) {
        $url = self::$api_url;
    
        if ($dni_empleado !== null) {
            $url .= "?dni_empleado=" . urlencode($dni_empleado);
        }
    
        $response = file_get_contents($url);
        $servicios = json_decode($response, true);
    
        return is_array($servicios) ? $servicios : [];
    }    

    public static function registrarServicio($fecha, $codigo_servicio, $id_perro, $dni_empleado, $precio_final, $incidencias = null) {
        $data = [
            "Fecha" => $fecha,
            "Codigo_Servicio" => $codigo_servicio,
            "ID_Perro" => $id_perro,
            "Dni_Empleado" => $dni_empleado,
            "Precio_Final" => $precio_final,
            "Incidencias" => $incidencias
        ];
        return self::postRequest($data);
    }

    public static function eliminarServicio($sr_cod) {
        $data = ["sr_cod" => $sr_cod];
        return self::deleteRequest($data);
    }

    private static function postRequest($data) {
        return self::sendRequest($data, "POST");
    }

    private static function deleteRequest($data) {
        return self::sendRequest($data, "DELETE");
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
