<?php
class LoginService {
    private static $api_url = "http://localhost/PHP_VETERINARIA/controllers/LoginController.php";

    public static function login($email, $password) {
        $data = [
            "email" => $email,
            "password" => $password
        ];
        return self::postRequest($data);
    }

    public static function logout() {
        return json_decode(file_get_contents(self::$api_url . "?logout=true"), true);
    }

    private static function postRequest($data) {
        $ch = curl_init(self::$api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}
?>
