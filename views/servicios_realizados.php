<?php
require_once "../frontcontroller.php";
require_once "../controllers/ServicioRealizadoController.php";
require_once "../services/EmpleadoService.php";

$controller = new ServicioRealizadoController();
// Obtener lista de empleados
$empleados = EmpleadoService::getEmpleados();

$servicios = $controller->listarServiciosRealizados();
$errorServicioRealizado = "";
$inserccionCorrecta = "";

// Si se aplica un filtro por empleado
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['dni_empleado']) && !empty($_GET['dni_empleado'])) {
    $servicios = $controller->listarServiciosPorEmpleado($_GET['dni_empleado']);
    $filtroActivo = true;
} else {
    $servicios = $controller->listarServiciosRealizados();
    $filtroActivo = false;
}

// Asegurarse de que `$servicios` sea un array válido para evitar errores
if (!is_array($servicios)) {
    $servicios = [];
}

// Si se está editando un servicio, se cargan los datos en el formulario
$editando = false;
$servicioEditar = [
    "Sr_Cod" => "",
    "Cod_Servicio" => "",
    "ID_Perro" => "",
    "Fecha" => "",
    "Incidencias" => "",
    "Precio_Final" => "",
    "Dni" => ""
];

// $errorServicioRealizado = "";

// Procesar inserción o actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "Cod_Servicio" => $_POST["Cod_Servicio"],
        "ID_Perro" => $_POST["ID_Perro"],
        "Fecha" => $_POST["Fecha"],
        "Incidencias" => $_POST["Incidencias"],
        "Precio_Final" => $_POST["Precio_Final"],
        "Dni" => $_POST["Dni"]
    ];

    // Validación form
    foreach ($data as $key => $value) {
        if (!isset($value) || $value == "") {
            $errorServicioRealizado = "Algún dato está vacío";
            break;
        } else if ($key === "Cod_Servicio" && in_array($value, array_column($servicios, "Cod_Servicio"))) {
            $errorServicioRealizado = "El servicio " . $value . " ya está realizado";
            break;
        }
    }

    if (!empty($_POST["update_id"]) && $errorServicioRealizado == "") {
        $inserccionCorrecta = "El servicio con el codigo " . $_POST["Cod_Servicio"] . " se ha insertado correctamente";
        $data["Sr_Cod"] = $_POST["update_id"];
        $controller->actualizarServicioRealizado($data);
    } else {
        $controller->agregarServicioRealizado($data);
    }

    header("Location: servicios_realizados.php");
    exit();
}

// Procesar eliminación
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete"])) {
    $controller->eliminarServicioRealizado($_GET["delete"]);
    header("Location: servicios_realizados.php");
    exit();
}

// Cargar datos para edición
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["edit"])) {
    $editando = true;
    foreach ($servicios as $servicio) {
        if ($servicio["Sr_Cod"] == $_GET["edit"]) {
            $servicioEditar = $servicio;
            break;
        }
    }
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
                <li><a class="text-lg text-white font-medium" href="./perros.php">Perros</a></li>
                <li><a class="text-lg text-white font-medium" href="./clientes.php">Clientes</a></li>
                <li><a class="text-lg text-white font-medium" href="./servicios_realizados.php">Servicios Realizados</a></li>
                <li><a class="text-lg text-white font-medium" href="./servicios.php">Servicios  </a></li>
                <li><a class="text-lg text-white font-medium p-2" href="./logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
        <h2 class="text-white text-2xl mb-5"><?php echo $editando ? "Modificar Servicio Realizado" : "Agregar Servicio Realizado"; ?></h2>
        <form method="POST" class="flex gap-5">
            <input type="hidden" name="update_id" value="<?= $editando ? $servicioEditar['Sr_Cod'] : "" ?>">
            <label class="text-white  text-center">Cod_Servicio <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="Cod_Servicio" value="<?= $editando ? $servicioEditar['Cod_Servicio'] : "" ?>"></label>
            <label class="text-white  text-center">ID_Perro <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" name="ID_Perro" value="<?= $editando ? $servicioEditar['ID_Perro'] : "" ?>"></label>
            <label class="text-white text-center">Fecha <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="date" name="Fecha" value="<?= $editando ? $servicioEditar['Fecha'] : "" ?>"></label>
            <label class="text-white  text-center">Incidencias <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="Incidencias" value="<?= $editando ? $servicioEditar['Incidencias'] : "" ?>"></label>
            <label class="text-white  text-center">Precio_Final <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" step="0.01" name="Precio_Final" value="<?= $editando ? $servicioEditar['Precio_Final'] : "" ?>"></label>
            <label class="text-white  text-center">Dni <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="Dni" value="<?= $editando ? $servicioEditar['Dni'] : "" ?>"></label>
            <button class="bg-indigo-900 rounded-sm p-2 text-white hover:bg-indigo-700" type="submit"><?= $editando ? "Guardar Cambios" : "Agregar" ?></button>
            <?php if ($editando): ?>
                <button class="bg-rose-400 rounded-sm p-2 text-white">
                    <a href="servicios_realizados.php">Cancelar</a>
                </button>
            <?php endif; ?>
        </form>

        <?php
        if ($errorServicioRealizado !== "") {
            echo '<p class="bg-rose-400">' . $errorServicioRealizado . '</p>';
        } else {
            echo '<p class = "text-emerald-400 mt-3">' . $inserccionCorrecta . '</p>';
        }
        ?>
    </div>

    <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
        <h2 class="text-white text-2xl mb-5">Filtrar por Empleado</h2>
        <form method="GET">
            <label class="text-white text-1xl mb-6 mr-7">Selecciona un empleado:</label>
            <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="dni_empleado">
                <option value="">Todos</option>
                <?php foreach ($empleados as $empleado): ?>
                    <option value="<?php echo $empleado['Dni']; ?>" <?php echo isset($_GET['dni_empleado']) && $_GET['dni_empleado'] == $empleado['Dni'] ? 'selected' : ''; ?>>
                        <?php echo $empleado['Nombre'] . " " . $empleado['Apellido1'] . " - " . $empleado['Dni']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit">Filtrar</button>
            <button class="bg-indigo-900 rounded-sm p-2 text-white">
                <a href="servicios_realizados.php">Quitar Filtros</a>
            </button>
        </form>

        <?php if ($filtroActivo && empty($servicios)): ?>
            <p class="text-rose-400 font-bold text-center">El empleado no tiene servicios.</p>
        <?php endif; ?>
    </div>

    <div class="bg-indigo-500 m-2 rounded-sm p-4">
        <?php if (!$filtroActivo || !empty($servicios)): ?>
            <h2 class="text-white text-2xl mb-5">Listar Servicios Realizados</h2>
            <table class="w-full">
                <tr class="flex gap-5 w-full mb-3">
                    <th class="w-[50px] text-white text-center">ID</th>
                    <th class="w-[100px] text-white text-center">Servicio</th>
                    <th class="w-[70px] text-white text-center">ID Perro</th>
                    <th class="w-[120px] text-white text-center ">Fecha</th>
                    <th class="w-[400px] text-white text-center">Incidencias</th>
                    <th class="w-[70px] text-white text-center">Precio</th>
                    <th class="w-[150px] text-white text-center">Dni</th>
                    <th class="text-white">Acciones</th>
                </tr>

                <?php foreach ($servicios as $servicio): ?>
                    <tr class="flex gap-5 w-full mb-3 text-center">
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[50px] text-[#E5E5E5]"><?= htmlspecialchars($servicio["Sr_Cod"] ?? 'N/A') ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?= htmlspecialchars($servicio["Cod_Servicio"] ?? 'N/A') ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[70px] text-[#E5E5E5]"><?= htmlspecialchars($servicio["ID_Perro"] ?? 'N/A') ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[120px] text-[#E5E5E5]"><?= htmlspecialchars($servicio["Fecha"] ?? 'N/A') ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[400px] text-[#E5E5E5]"><?= htmlspecialchars($servicio["Incidencias"] ?? 'Ninguna') ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[70px] text-[#E5E5E5]"><?= htmlspecialchars(number_format($servicio["Precio_Final"] ?? 0, 2)) . " €"; ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[150px] text-[#E5E5E5]"><?= htmlspecialchars($servicio["Dni"] ?? 'N/A') ?></td>
                        <td>
                            <a class="bg-rose-400 rounded-sm p-2 text-white" href="?edit=<?= $servicio["Sr_Cod"] ?>">Modificar</a>
                            <a class="bg-rose-400 rounded-sm p-2 text-white" href="?delete=<?= $servicio["Sr_Cod"] ?>" onclick="return confirm('¿Seguro que quieres eliminar este servicio?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>