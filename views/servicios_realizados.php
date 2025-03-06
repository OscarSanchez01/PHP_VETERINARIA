<?php
require_once "../frontcontroller.php";
require_once "../controllers/ServicioRealizadoController.php";
require_once "../services/EmpleadoService.php";
require_once "../controllers/ServicioController.php";
require_once "../controllers/PerroController.php";

$controller = new ServicioRealizadoController();
$controllerListar = new ServicioController();
$controllerListarPerro = new PerroController();
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

// Agregar servicios realizados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "Cod_Servicio" => $_POST["Cod_Servicio"],
        "ID_Perro" => $_POST["ID_Perro"],
        "Fecha" => $_POST["Fecha"],
        "Incidencias" => $_POST["Incidencias"],
        "Precio_Final" => $_POST["Precio_Final"],
        "Dni" => $_POST["Dni"]
    ];

    if (!empty($_POST["update_id"])) {
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
    <script>
        function abrirModalEditar(servicio) {
            document.getElementById("update_id").value = servicio.Sr_Cod;
            document.getElementById("edit_Cod_Servicio").value = servicio.Cod_Servicio;
            document.getElementById("edit_ID_Perro").value = servicio.ID_Perro;
            document.getElementById("edit_Fecha").value = servicio.Fecha;
            document.getElementById("edit_Incidencias").value = servicio.Incidencias;
            document.getElementById("edit_Precio_Final").value = servicio.Precio_Final;
            document.getElementById("edit_Dni").value = servicio.Dni;
            document.getElementById("modalEditar").style.display = "block";
        }
    </script>
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
                <li><a class="text-lg text-white font-medium" href="./servicios.php">Servicios</a></li>
                <?php if ($_SESSION['user_role'] === 'ADMIN'): ?>
                    <li><a class="text-lg text-white font-medium" href="./empleados.php">Empleados</a></li>
                <?php endif; ?>
                <li><a class="text-lg text-white font-medium p-2" href="./logout.php">Cerrar sesión</a></li>
                <?php echo $_SESSION['user_profesion']; ?>
            </ul>
        </nav>
    </header>

<!-- Modal Agregar -->
<?php if ($_SESSION["user_profesion"] != 'ATT.CLIENTE' && $_SESSION["user_profesion"] != 'AUXILIAR'): ?>
            <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
                <div id="modalAgregar" class="modal" class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
                <form method="POST">
                    <h2 class="text-white text-2xl mb-5">Agregar Servicio Realizado</h2>
                    <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="Cod_Servicio" onchange="rellenarPrecio(this.value)">
                        <option value="">Seleccione un servicio</option>
                        <?php 
                        $serviciosListar = $controllerListar->listarServicios();
                        foreach ($serviciosListar as $servicioListado): 
                            if ($_SESSION["user_profesion"] == 'NUTRICIONISTA' && strpos($servicioListado['Codigo'], 'SVNUT') === 0) {
                                $mostrar = true;
                            } elseif ($_SESSION["user_profesion"] == 'ESTILISTA' && strpos($servicioListado['Codigo'], 'SVBE') === 0) {
                                $mostrar = true;
                            }elseif ($_SESSION["user_role"] == 'ADMIN') {
                                $mostrar = true;
                            }else {
                                $mostrar = false;
                            }
                            if ($mostrar): ?>
                                <option value="<?php echo $servicioListado['Codigo']; ?>" <?php echo $editando && $servicioEditar['Cod_Servicio'] == $servicioListado['Codigo'] ? 'selected' : ''; ?>>
                                    <?php echo $servicioListado['Codigo'] . " - " . $servicioListado['Nombre']; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="ID_Perro">
                        <option value="">Seleccione un perro</option>
                        <?php 
                        $perros = $controllerListarPerro->listarPerros();
                        foreach ($perros as $perro): ?>
                            <option value="<?php echo $perro['ID_Perro']; ?>" <?php echo $editando && $servicioEditar['ID_Perro'] == $perro['ID_Perro'] ? 'selected' : ''; ?>>
                                <?php echo $perro['ID_Perro'] . " - " . $perro['Nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="date" name="Fecha" value="<?= $editando ? $servicioEditar['Fecha'] : "" ?>">
                    <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="Incidencias" placeholder="Incidencias" value="<?= $editando ? $servicioEditar['Incidencias'] : "" ?>">
                    <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" step="0.01" name="Precio_Final" placeholder="Precio en €" value="<?= $editando ? $servicioEditar['Precio_Final'] : "" ?>">
                    <script>
                        function rellenarPrecio(codigo) {
                            <?php 
                            $serviciosListar = $controllerListar->listarServicios();
                            foreach ($serviciosListar as $servicioListado): ?>
                                if (codigo == '<?php echo $servicioListado['Codigo']; ?>') {
                                    document.getElementsByName('Precio_Final')[0].value = '<?php echo $servicioListado['Precio']; ?>';
                                }
                            <?php endforeach; ?>
                        }
                    </script>
                    <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="Dni">
                        <option value="">Empleado</option>
                        <?php foreach ($empleados as $empleado): ?>
                            <option value="<?php echo $empleado['Dni']; ?>" <?php echo isset($_GET['dni_empleado']) && $_GET['dni_empleado'] == $empleado['Dni'] ? 'selected' : ''; ?>>
                                <?php echo $empleado['Nombre'] . " " . $empleado['Apellido1'] . " - " . $empleado['Dni']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button class="bg-indigo-900 rounded-sm p-2 text-white hover:bg-indigo-700" type="submit">Agregar</button>
                    <button class="bg-rose-400 rounded-sm p-2 text-white" type="button" onclick="document.getElementById('modalAgregar').style.display='none'">Cancelar</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Modal Editar -->
        <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10" id="modalEditar" class="modal" style="display:none;">
            <form method="POST">
                <h2 class="text-white text-2xl mb-5">Modificar Servicio Realizado</h2>
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="hidden" id="update_id" name="update_id">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" id="edit_Cod_Servicio" name="Cod_Servicio" placeholder="Código Servicio">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" id="edit_ID_Perro" name="ID_Perro" placeholder="ID Perro">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="date" id="edit_Fecha" name="Fecha">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" id="edit_Incidencias" name="Incidencias" placeholder="Incidencias">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" step="0.01" id="edit_Precio_Final" name="Precio_Final" placeholder="Precio en €">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" id="edit_Dni" name="Dni" placeholder="DNI Empleado">
                <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit">Modificar</button>
                <button class="bg-rose-400 rounded-sm p-2 text-white" type="button" onclick="document.getElementById('modalEditar').style.display='none'">Cancelar</button>
            </form>
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
            <table class="w-full flex flex-col items-center">
                <tr class="flex gap-5 w-full mb-3">
                    <th class="w-[100px] text-white text-center">Servicio</th>
                    <th class="w-[70px] text-white text-center">ID Perro</th>
                    <th class="w-[120px] text-white text-center ">Fecha</th>
                    <th class="w-[400px] text-white text-center">Incidencias</th>
                    <th class="w-[100px] text-white text-center">Precio</th>
                    <th class="w-[150px] text-white text-center">Dni</th>
                    <th class="w-[150px] text-white">Acciones</th>
                </tr>

                <?php foreach ($servicios as $servicio): ?>
                    <tr class="flex gap-5 w-full mb-3 text-center">
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?= htmlspecialchars($servicio["Cod_Servicio"] ?? 'N/A') ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[70px] text-[#E5E5E5]"><?= htmlspecialchars($servicio["ID_Perro"] ?? 'N/A') ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[120px] text-[#E5E5E5]"><?= htmlspecialchars($servicio["Fecha"] ?? 'N/A') ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[400px] text-[#E5E5E5]"><?= htmlspecialchars($servicio["Incidencias"] ?? 'Ninguna') ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?= htmlspecialchars(number_format($servicio["Precio_Final"] ?? 0, 2)) . " €"; ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[150px] text-[#E5E5E5]"><?= htmlspecialchars($servicio["Dni"] ?? 'N/A') ?></td>
                        <td>
                            <?php if ($_SESSION["user_profesion"] != 'ATT.CLIENTE' && $_SESSION["user_profesion"] != 'AUXILIAR'): ?>
                                <button class="bg-indigo-900 rounded-sm p-2 text-white" onclick='abrirModalEditar(<?= json_encode($servicio) ?>)'>Editar</button>
                            <?php endif; ?>
                            <?php if ($_SESSION['user_role'] !== 'AUXILIAR'): ?>
                                <a class="bg-rose-400 rounded-sm p-2 text-white" href="?delete=<?= $servicio["Sr_Cod"] ?>" onclick="return confirm('¿Seguro que quieres eliminar este servicio?')">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>