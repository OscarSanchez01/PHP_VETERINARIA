<?php
require_once "../frontcontroller.php";
require_once "../controllers/EmpleadoController.php";
$controller = new EmpleadoController();
$empleados = $controller->listarEmpleados();
$errorCrearEmpleados = "";
$empleado_existe = false;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    //Comprobamos que el no tenga datos vacios
    if (!isset($_POST['dni']) || $_POST['dni'] === '') {
        $errorCrearEmpleados = "El DNI no puede estar vacio";
    } else if (!isset($_POST['email']) || $_POST['email'] === '') {
        $errorCrearEmpleados = "El email no puede estar vacio";
    } else if (!isset($_POST['password']) || $_POST['password'] === '') {
        $errorCrearEmpleados = "La password no puede estar vacia";
    } else if (!isset($_POST['rol']) || $_POST['rol'] === '') {
        $errorCrearEmpleados = "El rol no puede estar vacio";
    } else if (!isset($_POST['nombre']) || $_POST['nombre'] === '') {
        $errorCrearEmpleados = "El nombre no puede estar vacio";
    } else if (!isset($_POST['apellido1']) || $_POST['apellido1'] === '') {
        $errorCrearEmpleados = "El primer apellido no puede estar vacio";
    } else if (!isset($_POST['apellido2']) || $_POST['apellido2'] === '') {
        $errorCrearEmpleados = "El segundo apellido no puede estar vacio";
    } else if (!isset($_POST['calle']) || $_POST['calle'] === '') {
        $errorCrearEmpleados = "La calle no puede estar vacia";
    } else if (!isset($_POST['numero']) || $_POST['numero'] === '') {
        $errorCrearEmpleados = "El numero no puede estar vacio";
    } else if (!isset($_POST['cp']) || $_POST['cp'] === '') {
        $errorCrearEmpleados = "La cp no puede estar vacia";
    } else if (!isset($_POST['poblacion']) || $_POST['poblacion'] === '') {
        $errorCrearEmpleados = "La poblacion no puede estar vacia";
    } else if (!isset($_POST['provincia']) || $_POST['provincia'] === '') {
        $errorCrearEmpleados = "La provincia no puede estar vacia";
    } else if (!isset($_POST['tlfno']) || $_POST['tlfno'] === '') {
        $errorCrearEmpleados = "El telefono no puede estar vacio";
    } else if (!isset($_POST['profesion']) || $_POST['profesion'] === '') {
        $errorCrearEmpleados = "La profesion no puede estar vacia";
    }

    //Controlar que el DNI no exitsa
    if ($errorCrearEmpleados === "") {
        //Comprobamos que no exista el codigo
        foreach ($empleados as $empleado) {
            if (!empty($empleado['Dni']) && trim(strval($empleado['Dni'])) === trim(strval($_POST['dni']))) {
                $empleado_existe = true;
                break;
            }
        }
        if ($empleado_existe) {
            $errorCrearEmpleados = "El empleado con el DNI " . $_POST['dni'] . " ya existe";
        }
    }

    if ($errorCrearEmpleados === "") {
        require_once "../services/EmpleadoService.php";
        EmpleadoService::crearEmpleado($_POST['dni'], $_POST['email'], $_POST['password'], $_POST['rol'], $_POST['nombre'], $_POST['apellido1'], $_POST['apellido2'], $_POST['calle'], $_POST['numero'], $_POST['cp'], $_POST['poblacion'], $_POST['provincia'], $_POST['tlfno'], $_POST['profesion']);
        header("Location: empleados.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    require_once "../services/EmpleadoService.php";
    EmpleadoService::actualizarEmpleado($_POST['dni'], $_POST['email'], $_POST['rol'], $_POST['nombre'], $_POST['apellido1'], $_POST['apellido2'], $_POST['tlfno'], $_POST['profesion']);
    header("Location: empleados.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $dni = $_POST['dni'];
    $ch = curl_init("http://localhost/gromer/SerWeb/empleados.php");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "dni=$dni");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    header("Location: empleados.php");
    exit;
}

$empleado_a_editar = null;
if (isset($_GET['editar'])) {
    foreach ($empleados as $empleado) {
        if ($empleado['Dni'] === $_GET['editar']) {
            $empleado_a_editar = $empleado;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Empleados</title>
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
                <li><a class="text-lg text-white font-medium" href="./servicios.php">Servicios</a></li>
                <li><a class="text-lg text-white font-medium" href="./empleados.php">Empleados</a></li>
                <li><a class="text-lg text-white font-medium p-2" href="./logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
        <h2 class="text-white text-2xl mb-5">Agregar Empleado</h2>
        <form method="POST" class="flex flex-wrap gap-5">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="dni" placeholder="DNI">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="email" name="email" placeholder="Correo Electrónico">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="password" name="password" placeholder="Contraseña">
            <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="rol">
                <option value="ADMIN">ADMIN</option>
                <option value="EMPLEADO">EMPLEADO</option>
                <option value="AUXILIAR">AUXILIAR</option>
            </select>
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="nombre" placeholder="Nombre">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="apellido1" placeholder="Apellido 1">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="apellido2" placeholder="Apellido 2">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="calle" placeholder="Calle">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" name="numero" placeholder="Número">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="cp" placeholder="Código Postal">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="poblacion" placeholder="Población">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="provincia" placeholder="Provincia">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="tlfno" placeholder="Teléfono">
            <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="profesion">
                <option value="NUTRICIONISTA">NUTRICIONISTA</option>
                <option value="ESTILISTA">ESTILISTA</option>
                <option value="AUXILIAR">AUXILIAR</option>
                <option value="ATT.CLIENTE">ATT. CLIENTE</option>
                <option value="ADMIN">ADMIN</option>
            </select>
            <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit" name="agregar">Agregar Empleado</button>
        </form>
        <?php
        if ($errorCrearEmpleados !== "") {
            echo '<p class="text-rose-400 mt-3">' . $errorCrearEmpleados . '</p>';
        }
        ?>
    </div>

    <?php if ($empleado_a_editar): ?>
        <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
            <h2 class="text-white text-2xl mb-5">Editar Empleado</h2>
            <form method="POST" class="flex flex-wrap gap-5">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="hidden" name="dni" value="<?php echo $empleado_a_editar['Dni']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="email" name="email" placeholder="Correo Electrónico" required value="<?php echo $empleado_a_editar['Email']; ?>">
                <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="rol" required>
                    <option value="ADMIN" <?php echo ($empleado_a_editar['Rol'] === 'ADMIN') ? 'selected' : ''; ?>>ADMIN</option>
                    <option value="EMPLEADO" <?php echo ($empleado_a_editar['Rol'] === 'EMPLEADO') ? 'selected' : ''; ?>>EMPLEADO</option>
                    <option value="AUXILIAR" <?php echo ($empleado_a_editar['Rol'] === 'AUXILIAR') ? 'selected' : ''; ?>>AUXILIAR</option>
                </select>
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="nombre" placeholder="Nombre" required value="<?php echo $empleado_a_editar['Nombre']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="apellido1" placeholder="Apellido 1" required value="<?php echo $empleado_a_editar['Apellido1']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="apellido2" placeholder="Apellido 2" value="<?php echo $empleado_a_editar['Apellido2']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="tlfno" placeholder="Teléfono" required value="<?php echo $empleado_a_editar['Tlfno']; ?>">
                <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="profesion" required>
                    <option value="NUTRICIONISTA" <?php echo ($empleado_a_editar['Profesion'] === 'NUTRICIONISTA') ? 'selected' : ''; ?>>NUTRICIONISTA</option>
                    <option value="ESTILISTA" <?php echo ($empleado_a_editar['Profesion'] === 'ESTILISTA') ? 'selected' : ''; ?>>ESTILISTA</option>
                    <option value="AUXILIAR" <?php echo ($empleado_a_editar['Profesion'] === 'AUXILIAR') ? 'selected' : ''; ?>>AUXILIAR</option>
                    <option value="ATT.CLIENTE" <?php echo ($empleado_a_editar['Profesion'] === 'ATT.CLIENTE') ? 'selected' : ''; ?>>ATT. CLIENTE</option>
                    <option value="ADMIN" <?php echo ($empleado_a_editar['Profesion'] === 'ADMIN') ? 'selected' : ''; ?>>ADMIN</option>
                </select>
                <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit" name="actualizar">Actualizar Empleado</button>
                <a class="bg-rose-400 rounded-sm p-2 text-white" href="empleados.php">Cancelar</a>
            </form>
        </div>
    <?php endif; ?>

    <div class="bg-indigo-500 m-2 rounded-sm p-4">
        <h2 class="text-white text-2xl mb-5">Lista de Empleados</h2>
        <table class="w-full">
            <tr class="flex gap-5 w-full mb-3">
                <th class="w-[120px] text-white text-center">DNI</th>
                <th class="w-[300px] text-white text-center">Email</th>
                <th class="w-[140px] text-white text-center">Rol</th>
                <th class="w-[140px] text-white text-center">Nombre</th>
                <th class="w-[140px] text-white text-center">Teléfono</th>
                <th class="w-[140px] text-white text-center">Acciones</th>
            </tr>
            <?php foreach ($empleados as $empleado): ?>
                <tr class="flex gap-5 w-full mb-3">
                    <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[120px] text-[#E5E5E5]"><?php echo $empleado['Dni']; ?></td>
                    <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[300px] text-[#E5E5E5]"><?php echo $empleado['Email']; ?></td>
                    <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[140px] text-[#E5E5E5]"><?php echo $empleado['Rol']; ?></td>
                    <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[140px] text-[#E5E5E5]"><?php echo $empleado['Nombre']; ?></td>
                    <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[140px] text-[#E5E5E5]"><?php echo $empleado['Tlfno']; ?></td>
                    <td class="flex items-center gap-3">
                        <a class="bg-indigo-900 rounded-sm p-2 text-white w-[60px]" href="empleados.php?editar=<?php echo $empleado['Dni']; ?>">Editar</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="dni" value="<?php echo $empleado['Dni']; ?>">
                            <button class="bg-rose-400 rounded-sm p-2 text-white" type="submit" name="eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>