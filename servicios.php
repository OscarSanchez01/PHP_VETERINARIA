 <?php
    require_once "../frontcontroller.php";
    require_once "../controllers/ServicioController.php";
    $controller = new ServicioController();
    $servicios = $controller->listarServicios();
    $errorCrearServicio = "";
    $servicio_existe = false;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
        //Comprobamos que el no tenga datos vacios
        if (!isset($_POST['codigo']) || $_POST['codigo'] === '') {
            $errorCrearServicio = "El codigo no puede estar vacio";
        } else if (!isset($_POST['nombre']) || $_POST['nombre'] === '') {
            $errorCrearServicio = "El nombre no puede estar vacio";
        } else if (!isset($_POST['precio']) || $_POST['precio'] === '') {
            $errorCrearServicio = "El precio no puede estar vacio";
        }

        if ($errorCrearServicio === "") {
            //Comprobamos que no exista el codigo
            foreach ($servicios as $servicio) {
                if (!empty($servicio['Codigo']) && trim(strval($servicio['Codigo'])) === trim(strval($_POST['codigo']))) {
                    $servicio_existe = true;
                    break;
                }
            }
            if ($servicio_existe) {
                $errorCrearServicio = "El servicio con el codigo " . $_POST['codigo'] . " ya existeServicio";
            }
        }
        if ($errorCrearServicio === "") {
            require_once "../services/ServicioService.php";
            ServicioService::crearServicio($_POST['codigo'], $_POST['nombre'], $_POST['precio'], $_POST['descripcion']);
            header("Location: servicios.php");
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
        require_once "../services/ServicioService.php";
        ServicioService::actualizarPrecioServicio($_POST['codigo'], $_POST['precio']);
        header("Location: servicios.php");
        exit;
    }

// Procesar eliminación
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete"])) {
    $controller->eliminarServicio($_GET["delete"]);
    header("Location: servicios.php");
    exit();
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

     <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
         <h2 class="text-white text-2xl mb-5">Agregar Servicio</h2>
         <form method="POST" class="flex flex-wrap gap-5">
             <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="codigo" placeholder="Código">
             <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="nombre" placeholder="Nombre del Servicio">
             <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" step="0.01" name="precio" placeholder="Precio (€)">
             <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="descripcion" placeholder="Descripción">
             <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit" name="agregar">Agregar Servicio</button>
         </form>
         <?php
            if ($errorCrearServicio !== "") {
                echo '<p class="text-rose-400 mt-3">' . $errorCrearServicio . '</p>';
            }
            ?>
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
         <table class="w-full flex flex-col items-center">
             <tr class="flex gap-5 w-full mb-3">
                 <th class="w-[110px] text-white text-center">Código</th>
                 <th class="w-[150px] text-white text-center">Nombre</th>
                 <th class="w-[100px] text-white text-center">Precio</th>
                 <th class="w-[500px] text-white text-center">Descripción</th>
                 <th class="w-[110px] text-white text-center">Acciones</th>
             </tr>
             <?php foreach ($servicios as $servicio): ?>
                 <tr class="flex gap-5 w-full mb-3">
                     <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?php echo $servicio['Codigo']; ?></td>
                     <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[150px] text-[#E5E5E5]"><?php echo $servicio['Nombre']; ?></td>
                     <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?php echo number_format($servicio['Precio'], 2); ?> €</td>
                     <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[500px] text-[#E5E5E5]"><?php echo $servicio['Descripcion']; ?></td>
                     <td class="flex justify-center items-center gap-2 w-[120px]">
                         <a class="bg-indigo-900 rounded-sm p-2 text-white w-[60px]" href="servicios.php?editar=<?php echo $servicio['Codigo']; ?>">Editar</a>
                         <?php if ($_SESSION['user_role'] !== 'AUXILIAR'): ?>
                             <form method="POST" style="display:inline;">
                                 <input type="hidden" name="codigo" value="<?php echo $servicio['Codigo']; ?>">
                                 <a class="bg-rose-400 rounded-sm p-2 text-white" href="?delete=<?= $servicio["Codigo"] ?>" onclick="return confirm('¿Seguro que quieres eliminar este servicio?')">Eliminar</a>
                             </form>
                         <?php endif; ?>
                     </td>
                 </tr>
             <?php endforeach; ?>
         </table>
     </div>
 </body>

 </html>