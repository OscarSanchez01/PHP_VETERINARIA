<?php
class ServicioRealizadoService {
    private static $api_url = "http://localhost/PHP_VETERINARIA/SerWeb/servicios_realizados.php";

    // Obtener todos los servicios realizados
    public static function getServicios() {
        $response = file_get_contents(self::$api_url);
        return json_decode($response, true);
    }

    // Agregar un nuevo servicio realizado
    public static function addServicioRealizado($data) {
        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents(self::$api_url, false, $context);
        return json_decode($response, true);
    }

    // Eliminar un servicio realizado
    public static function deleteServicioRealizado($sr_cod) {
        $options = [
            'http' => [
                'method'  => 'DELETE',
                'content' => http_build_query(['Sr_Cod' => $sr_cod])
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents(self::$api_url, false, $context);
        return json_decode($response, true);
    }
}
?>
