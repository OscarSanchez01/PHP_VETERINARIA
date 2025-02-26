<?php
require_once "../controllers/PerroController.php";
$controller = new PerroController();
$perros = $controller->listarPerros();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    require_once "../services/PerroService.php";
    PerroService::crearPerro($_POST['dni_duenio'], $_POST['nombre'], $_POST['fecha_nacimiento'], $_POST['raza'], $_POST['peso'], $_POST['altura'], $_POST['observaciones'], $_POST['numero_chip'], $_POST['sexo']);
    header("Location: perros.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    require_once "../services/PerroService.php";
    PerroService::actualizarPerro($_POST['id_perro'], $_POST['nombre'], $_POST['raza'], $_POST['fecha_nacimiento'], $_POST['peso'], $_POST['altura'], $_POST['observaciones'], $_POST['numero_chip'], $_POST['sexo'], $_POST['dni_duenio']);
    header("Location: perros.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id_perro = $_POST['id_perro'];
    $ch = curl_init("http://localhost/gromer/SerWeb/perros.php");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "id_perro=$id_perro");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    header("Location: perros.php");
    exit;
}

$perro_a_editar = null;
if (isset($_GET['editar'])) {
    foreach ($perros as $perro) {
        if ((string) $perro['ID_Perro'] === $_GET['editar']) {  // Convertimos a string para evitar errores de tipo
            $perro_a_editar = $perro;
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
                <li><a class="text-lg text-white font-medium" href="./dashboard.php">Inicio</a></li>
                <li><a class="text-lg text-white font-medium" href="./perros.php">Perros</a></li>
                <li><a class="text-lg text-white font-medium" href="./clientes.php">Clientes</a></li>
                <li><a class="text-lg text-white font-medium" href="./servicios_realizados.php">Servicios Realizados</a></li>
                <li><a class="text-lg text-white font-medium" href="./logout.php">Logaout</a></li>
            </ul>
        </nav>
    </header>

    <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
        <h2 class="text-white text-2xl mb-5">Agregar Perro</h2>
        <form method="POST" class="flex flex-wrap gap-5">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="dni_duenio" placeholder="DNI Dueño" required>
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="nombre" placeholder="Nombre" required>
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="date" name="fecha_nacimiento" required>
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="raza" placeholder="Raza" required>
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" name="peso" placeholder="Peso (kg)" required>
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" name="altura" placeholder="Altura (cm)" required>
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="observaciones" placeholder="Observaciones">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="numero_chip" placeholder="Número de Chip" required>
            <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="sexo" required>
                <option value="Macho">Macho</option>
                <option value="Hembra">Hembra</option>
            </select>
            <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit" name="agregar">Agregar Perro</button>
        </form>
    </div>

    <?php if ($perro_a_editar): ?>
        <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
            <h2 class="text-white text-2xl mb-5">Editar Perro</h2>
            <form method="POST" class="flex flex-wrap gap-5">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="hidden" name="id_perro" value="<?php echo $perro_a_editar['ID_Perro']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="dni_duenio" placeholder="DNI Dueño" required value="<?php echo $perro_a_editar['Dni_duenio']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="nombre" placeholder="Nombre" required value="<?php echo $perro_a_editar['Nombre']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="date" name="fecha_nacimiento" required value="<?php echo $perro_a_editar['Fecha_Nto']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="raza" placeholder="Raza" required value="<?php echo $perro_a_editar['Raza']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" name="peso" placeholder="Peso (kg)" required value="<?php echo $perro_a_editar['Peso']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" name="altura" placeholder="Altura (cm)" required value="<?php echo $perro_a_editar['Altura']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="observaciones" placeholder="Observaciones" value="<?php echo $perro_a_editar['Observaciones']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="numero_chip" placeholder="Número de Chip" required value="<?php echo $perro_a_editar['Numero_Chip']; ?>">
                <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="sexo" required>
                    <option value="Macho" <?php echo ($perro_a_editar['Sexo'] === 'Macho') ? 'selected' : ''; ?>>Macho</option>
                    <option value="Hembra" <?php echo ($perro_a_editar['Sexo'] === 'Hembra') ? 'selected' : ''; ?>>Hembra</option>
                </select>
                <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit" name="actualizar">Actualizar Perro</button>
                <button class="bg-rose-400 rounded-sm p-2 text-white" type="submit" name="actualizar"><a href="perros.php">Cancelar</a></button>
            </form>
        </div>
    <?php endif; ?>

    <div class="bg-indigo-500 m-2 rounded-sm p-4">
        <h2 class="text-white text-2xl mb-5">Lista de Perros</h2>
        <table class="w-full">
            <tr class="flex gap-5 w-full mb-3">
                <!-- <th>ID</th> -->
                <th class="w-[120px] text-white text-center">Nombre</th>
                <th class="w-[150px] text-white text-center">Raza</th>
                <th class="w-[100px] text-white text-center">Nacimiento</th>
                <th class="w-[100px] text-white text-center">Peso</th>
                <th class="w-[60px] text-white text-center">Altura</th>
                <th class="w-[160px] text-white text-center">Chip</th>
                <th class="w-[80px] text-white text-center">Sexo</th>
                <th class="w-[120px] text-white text-center">Dueño</th>
                <th class="w-[120px] text-white text-center">Acciones</th>
            </tr>
            <?php foreach ($perros as $perro): ?>
                <tr class="flex gap-5 w-full mb-3">
                    <!-- <td><?php echo $perro['ID_Perro']; ?></td> -->
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[120px] text-[#E5E5E5]"><?php echo $perro['Nombre']; ?></td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[150px] text-[#E5E5E5]"><?php echo $perro['Raza']; ?></td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?php echo $perro['Fecha_Nto']; ?></td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?php echo $perro['Peso']; ?> kg</td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[60px] text-[#E5E5E5]"><?php echo $perro['Altura']; ?> cm</td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[160px] text-[#E5E5E5]"><?php echo $perro['Numero_Chip']; ?></td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[80px] text-[#E5E5E5]"><?php echo $perro['Sexo']; ?></td>
                    <td class="bg-indigo-300 rounded-sm p-2 text-center w-[120px] text-[#E5E5E5]"><?php echo $perro['Dni_duenio']; ?></td>
                    <td>
                        <button class="bg-indigo-900 rounded-sm p-2 text-white w-[70px]"><a href="perros.php?editar=<?php echo $perro['ID_Perro']; ?>">Editar</a></button>
                        <form method="POST" class="inline">
                            <input type="hidden" name="id_perro" value="<?php echo $perro['ID_Perro']; ?>">
                            <button class="bg-rose-400 rounded-sm p-2 text-white" type="submit" name="eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>