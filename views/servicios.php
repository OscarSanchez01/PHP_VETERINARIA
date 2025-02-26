 <?php
session_start();
require_once "../controllers/ServicioController.php";
$controller = new ServicioController();
$servicios = $controller->listarServicios();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    require_once "../services/ServicioService.php";
    ServicioService::crearServicio($_POST['codigo'], $_POST['nombre'], $_POST['precio'], $_POST['descripcion']);
    header("Location: servicios.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    require_once "../services/ServicioService.php";
    ServicioService::actualizarPrecioServicio($_POST['codigo'], $_POST['precio']);
    header("Location: servicios.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $codigo = $_POST['codigo'];
    $ch = curl_init("http://localhost/gromer/SerWeb/servicios.php");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "codigo=$codigo");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    header("Location: servicios.php");
    exit;
}

$servicio_a_editar = null;
if (isset($_GET['editar'])) {
    foreach ($servicios as $servicio) {
        if ($servicio['Codigo'] === $_GET['editar']) {
            $servicio_a_editar = $servicio;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Servicios</title>
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <link rel="shortcut icon" href="./../assets/images/logo.png" type="image/x-icon">
    </head>
    <body>
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
            <h2 class="text-white text-2xl mb-5">Agregar Servicio</h2>
            <form method="POST" class="flex flex-wrap gap-5">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="codigo" placeholder="Código" required>
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="nombre" placeholder="Nombre del Servicio" required>
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" step="0.01" name="precio" placeholder="Precio (€)" required>
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="descripcion" placeholder="Descripción" required>
                <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit" name="agregar">Agregar Servicio</button>
            </form>
        </div>

        <?php if ($servicio_a_editar): ?>
            <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
                <h2 class="text-white text-2xl mb-5">Editar Precio del Servicio</h2>
                <form method="POST" class="flex flex-wrap gap-5">
                    <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="hidden" name="codigo" value="<?php echo $servicio_a_editar['Codigo']; ?>">
                    <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" step="0.01" name="precio" placeholder="Nuevo Precio (€)" required value="<?php echo $servicio_a_editar['Precio']; ?>">
                    <button class="bg-rose-400 rounded-sm p-2 text-white" type="submit" name="actualizar">Actualizar Precio</button>
                    <a class="bg-rose-400 rounded-sm p-2 text-white" href="servicios.php">Cancelar</a>
                </form>
            </div>
        <?php endif; ?>

        <div class="bg-indigo-500 m-2 rounded-sm p-4">
            <h2 class="text-white text-2xl mb-5">Lista de Servicios</h2>
            <table class="w-full">
                <tr class="flex gap-5 w-full mb-3">
                    <th class="w-[110px] text-white text-center">Código</th>
                    <th class="w-[150px] text-white text-center">Nombre</th>
                    <th class="w-[100px] text-white text-center">Precio</th>
                    <th class="w-[500px] text-white text-center">Descripción</th>
                    <th class="w-[180px] text-white text-center">Acciones</th>
                </tr>
                <?php foreach ($servicios as $servicio): ?>
                    <tr class="flex gap-5 w-full mb-3">
                        <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?php echo $servicio['Codigo']; ?></td>
                        <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[150px] text-[#E5E5E5]"><?php echo $servicio['Nombre']; ?></td>
                        <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?php echo number_format($servicio['Precio'], 2); ?> €</td>
                        <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[500px] text-[#E5E5E5]"><?php echo $servicio['Descripcion']; ?></td>
                        <td class="flex items-center gap-3">
                            <a class="bg-indigo-900 rounded-sm p-2 text-white w-[90px]" href="servicios.php?editar=<?php echo $servicio['Codigo']; ?>">✏️ Editar</a>
                            <?php if ($_SESSION['user_role'] !== 'AUXILIAR'): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="codigo" value="<?php echo $servicio['Codigo']; ?>">
                                    <button class="bg-rose-400 rounded-sm p-2 text-white" type="submit" name="eliminar">❌ Eliminar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
</html>
