<?php
class ServicioRealizadoService {
    private static $api_url = "http://localhost/PHP_VETERINARIA/SerWeb/servicios_realizados.php";

    // Obtener todos los servicios realizados
    public static function getServicios($dni_empleado = null) {
        $url = self::$api_url;
    
        if ($dni_empleado !== null) {
            $url .= "?dni_empleado=" . urlencode($dni_empleado);
        }
    
        // Obtiene la respuesta de la API
        $response = @file_get_contents($url);
    
        // Verifica si la respuesta está vacía o es falsa
        if ($response === false || empty($response)) {
            return ["error" => "No se pudo obtener la información de la API."];
        }
    
        // Decodifica la respuesta JSON
        $servicios = json_decode($response, true);
    
        // Si json_decode devuelve null, significa que la respuesta no era JSON válido
        if ($servicios === null) {
            return ["error" => "Error al decodificar la respuesta JSON.", "raw_response" => $response];
        }
    
        // Si no es un array, forzar a devolverlo como array vacío para evitar errores
        return is_array($servicios) ? $servicios : [];
    }

    // Agregar un nuevo servicio realizado

    // Agregar un nuevo servicio realizado
    public static function addServicioRealizado($data)
    {
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
    
    // Actualizar un servicio
    public static function updateServicioRealizado($data)
    {
        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'PUT',
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
    
    // Listar por servicios de un empleado seleccionado
    public static function getServiciosPorEmpleado($dni_empleado) {
        $url = self::$api_url . "?dni_empleado=" . urlencode($dni_empleado);
        $response = file_get_contents($url);
        $servicios = json_decode($response, true);
        
        return is_array($servicios) ? $servicios : [];
    }
}
?>
