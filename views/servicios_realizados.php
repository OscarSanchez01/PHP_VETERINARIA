<?php
require_once "../controllers/ServicioRealizadoController.php";
$controller = new ServicioRealizadoController();
$servicios = $controller->listarServiciosRealizados();
$errorServicioRealizado = "";
$inserccionCorrecta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = [
        "Cod_Servicio" => $_POST["Cod_Servicio"],
        "ID_Perro" => $_POST["ID_Perro"],
        "Fecha" => $_POST["Fecha"],
        "Incidencias" => $_POST["Incidencias"],
        "Precio_Final" => $_POST["Precio_Final"],
        "Dni" => $_POST["Dni"]
    ];
    foreach ($data as $key => $value) {
        if (!isset($value) || $value == "") {
            $errorServicioRealizado = "Algún dato está vacío";
            break;
        } else if ($key === "Cod_Servicio" && in_array($value, array_column($servicios, "Cod_Servicio"))) {
            $errorServicioRealizado = "El servicio " . $value . " ya está realizado";
            break;
        }
    }

    if ($errorServicioRealizado == "") {
        $inserccionCorrecta = "El servicio con el codigo " . $_POST["Cod_Servicio"] . " se ha insertado correctamente";
        $controller->agregarServicioRealizado($data);
        header("Location: servicios_realizados.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete"])) {
    $controller->eliminarServicioRealizado($_GET["delete"]);
    header("Location: servicios_realizados.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Servicios Realizados</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="./../assets/images/logo.png" type="image/x-icon">
</head>

<body class="bg-indigo-200">
    <header class="flex justify-between items-center bg-rose-500 mb-14 p-2 h-[100px]">
        <div class="flex gap-4 items-center">
            <img src="./../assets/images/logo.png" class="w-[50px] h-[50px] rounded-3xl" alt="">
            <h1 class="text-2xl text-white font-medium">Veterineria Ribera</h1>
        </div>
        <nav class="mr-7">
            <ul class="flex gap-5">
                <li><a class="text-lg text-white font-medium" href="./dashboard.php">Inicio</a></li>
                <li><a class="text-lg text-white font-medium" href="./perros.php">Perros</a></li>
                <li><a class="text-lg text-white font-medium" href="./clientes.php">Clientes</a></li>
                <li><a class="text-lg text-white font-medium" href="./servicios_realizados.php">Servicios Realizados</a></li>
                <li><a class="text-lg text-white font-medium" href="./logout.php">Logaout</a></li>
            </ul>
        </nav>
    </header>
    <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
        <h2 class="text-white text-2xl mb-5">Agregar Servicio Realizado</h2>
        <form method="POST" class="flex gap-5">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="Cod_Servicio" placeholder="Codigo de Servicio">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" name="ID_Perro" placeholder="ID Perro">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="date" name="Fecha">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="Incidencias" placeholder="Incidencias"></label>
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" step="0.01" name="Precio_Final" placeholder="Precio en €"></label>
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="Dni" placeholder="DNI">
            <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit">Agregar</button>
        </form>
        <?php
        if ($errorServicioRealizado !== "") {
            echo '<p class = "text-rose-400 mt-3">' . $errorServicioRealizado . '</p>';
        } else {
            echo '<p class = "text-emerald-400 mt-3">' . $inserccionCorrecta . '</p>';
        }
        ?>
    </div>

    <div class="bg-indigo-500 m-2 rounded-sm p-4">
        <h2 class="text-white text-2xl mb-5">Listar Servicios Realizados</h2>
        <table class="w-full">
            <tr class="flex gap-5 w-full mb-3">
                <!-- <th class="text-white text-center">ID</th> -->
                <th class="w-[100px] text-white text-center">Servicio</th>
                <th class="w-[100px] text-white text-center">ID Perro</th>
                <th class="w-[98px] text-white text-center ">Fecha</th>
                <th class="w-[400px] text-white text-center">Incidencias</th>
                <th class="w-[70px] text-white text-center">Precio</th>
                <th class="w-[150px] text-white text-center">Dni</th>
                <th class="text-white">Acciones</th>
            </tr>
            <?php foreach ($servicios as $servicio): ?>
                <tr class="flex gap-5 w-full mb-3">
                    <!-- <td class="bg-indigo-300 rounded-sm p-2 text-center"><?= $servicio["Sr_Cod"] ?></td> -->
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?= $servicio["Cod_Servicio"] ?></td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?= $servicio["ID_Perro"] ?></td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center text-[#E5E5E5]"><?= $servicio["Fecha"] ?></td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[400px] text-[#E5E5E5]"><?= $servicio["Incidencias"] ?></td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[70px] text-[#E5E5E5]"><?= $servicio["Precio_Final"] ?>€</td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[150px] text-[#E5E5E5]"><?= $servicio["Dni"] ?></td>
                    <td class="bg-rose-400 rounded-sm p-2 text-white"><a href="?delete=<?= $servicio["Sr_Cod"] ?>">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>