<?php
require_once "../frontcontroller.php";
require_once "../controllers/EmpleadoController.php";
$controller = new EmpleadoController();
$empleados = $controller->listarEmpleados();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    require_once "../services/EmpleadoService.php";
    EmpleadoService::crearEmpleado($_POST['dni'], $_POST['email'], $_POST['password'], $_POST['rol'], $_POST['nombre'], $_POST['apellido1'], $_POST['apellido2'], $_POST['calle'], $_POST['numero'], $_POST['cp'], $_POST['poblacion'], $_POST['provincia'], $_POST['tlfno'], $_POST['profesion']);
    header("Location: empleados.php");
    exit;
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
                    <li><a class="text-lg text-white font-medium" href="./servicios.php">Servicios  </a></li>
                    <li><a class="text-lg text-white font-medium p-2" href="./logout.php">Cerrar sesión</a></li>
                </ul>
            </nav>
        </header>

        <h2>Agregar Empleado</h2>
        <form method="POST">
            <input type="text" name="dni" placeholder="DNI" required>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <select name="rol" required>
                <option value="ADMIN">ADMIN</option>
                <option value="EMPLEADO">EMPLEADO</option>
                <option value="AUXILIAR">AUXILIAR</option>
            </select>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido1" placeholder="Apellido 1" required>
            <input type="text" name="apellido2" placeholder="Apellido 2">
            <input type="text" name="calle" placeholder="Calle">
            <input type="number" name="numero" placeholder="Número">
            <input type="text" name="cp" placeholder="Código Postal">
            <input type="text" name="poblacion" placeholder="Población">
            <input type="text" name="provincia" placeholder="Provincia">
            <input type="text" name="tlfno" placeholder="Teléfono" required>
            <select name="profesion" required>
                <option value="NUTRICIONISTA">NUTRICIONISTA</option>
                <option value="ESTILISTA">ESTILISTA</option>
                <option value="AUXILIAR">AUXILIAR</option>
                <option value="ATT.CLIENTE">ATT. CLIENTE</option>
                <option value="ADMIN">ADMIN</option>
            </select>
            <button type="submit" name="agregar">Agregar Empleado</button>
        </form>

        <?php if ($empleado_a_editar): ?>
            <h2>Editar Empleado</h2>
            <form method="POST">
                <input type="hidden" name="dni" value="<?php echo $empleado_a_editar['Dni']; ?>">
                <input type="email" name="email" placeholder="Correo Electrónico" required value="<?php echo $empleado_a_editar['Email']; ?>">
                <select name="rol" required>
                    <option value="ADMIN" <?php echo ($empleado_a_editar['Rol'] === 'ADMIN') ? 'selected' : ''; ?>>ADMIN</option>
                    <option value="EMPLEADO" <?php echo ($empleado_a_editar['Rol'] === 'EMPLEADO') ? 'selected' : ''; ?>>EMPLEADO</option>
                    <option value="AUXILIAR" <?php echo ($empleado_a_editar['Rol'] === 'AUXILIAR') ? 'selected' : ''; ?>>AUXILIAR</option>
                </select>
                <input type="text" name="nombre" placeholder="Nombre" required value="<?php echo $empleado_a_editar['Nombre']; ?>">
                <input type="text" name="apellido1" placeholder="Apellido 1" required value="<?php echo $empleado_a_editar['Apellido1']; ?>">
                <input type="text" name="apellido2" placeholder="Apellido 2" value="<?php echo $empleado_a_editar['Apellido2']; ?>">
                <input type="text" name="tlfno" placeholder="Teléfono" required value="<?php echo $empleado_a_editar['Tlfno']; ?>">
                <select name="profesion" required>
                    <option value="NUTRICIONISTA" <?php echo ($empleado_a_editar['Profesion'] === 'NUTRICIONISTA') ? 'selected' : ''; ?>>NUTRICIONISTA</option>
                    <option value="ESTILISTA" <?php echo ($empleado_a_editar['Profesion'] === 'ESTILISTA') ? 'selected' : ''; ?>>ESTILISTA</option>
                    <option value="AUXILIAR" <?php echo ($empleado_a_editar['Profesion'] === 'AUXILIAR') ? 'selected' : ''; ?>>AUXILIAR</option>
                    <option value="ATT.CLIENTE" <?php echo ($empleado_a_editar['Profesion'] === 'ATT.CLIENTE') ? 'selected' : ''; ?>>ATT. CLIENTE</option>
                    <option value="ADMIN" <?php echo ($empleado_a_editar['Profesion'] === 'ADMIN') ? 'selected' : ''; ?>>ADMIN</option>
                </select>
                <button type="submit" name="actualizar">Actualizar Empleado</button>
                <a href="empleados.php">Cancelar</a>
            </form>
        <?php endif; ?>

        <h2>Lista de Empleados</h2>
        <table border="1">
            <tr>
                <th>DNI</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?php echo $empleado['Dni']; ?></td>
                    <td><?php echo $empleado['Email']; ?></td>
                    <td><?php echo $empleado['Rol']; ?></td>
                    <td><?php echo $empleado['Nombre']; ?></td>
                    <td><?php echo $empleado['Tlfno']; ?></td>
                    <td>
                        <a href="empleados.php?editar=<?php echo $empleado['Dni']; ?>">✏️ Editar</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="dni" value="<?php echo $empleado['Dni']; ?>">
                            <button type="submit" name="eliminar">❌ Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </body>

</html>