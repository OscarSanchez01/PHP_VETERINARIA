Instrucciones para desplegar el proyecto de la GROMMER en XAMPP 
(Oscar Sanchez Avellan, Carlos Alfaro Paniagua, Rodrigo Moreno Bielsa y Daniel Martin Rol)


1. Colocar el Proyecto en la Carpeta Correcta

	Descarga el proyecto PHP_VETERINARIA y copia la carpeta del proyecto en la siguiente ruta:

	C:\xampp\htdocs\PHP_VETERINARIA
	
	ES IMPORTANTE QUE LA CARPETA SE LLAME JUSTO ASÍ, SI NO PUEDE QUE ALGUNAS
	RUTAS PUEDAN DAR CONFLICTOS.

2. Iniciar los Servicios de XAMPP

	Abre XAMPP Control Panel e inicia los siguientes servicios:

	Apache (servidor web)

	MySQL (servidor de base de datos)

3. Configurar la Base de Datos

	Antes de ejecutar el proyecto, es necesario importar la base de datos, abre tu navegador y accede a 
	http://localhost/phpmyadmin. Importa la base de datos llamada 'gromer.sql' situada en la ruta:

	C:\xampp\htdocs\PHP_VETERINARIA\config\gromer.sql

	Con el usuario root y sin contraseña es como debes acceder a la base de datos.


4. Ejecutar el Proyecto en el Navegador

	Una vez que los servicios estén en ejecución y la base de datos esté configurada, abre el navegador web y busca:

	http://localhost/PHP_VETERINARIA

5. Acceder al Proyecto

	Si quieres acceder como administrador, podrás acceder con el usuario admin@admin.es y la contraseña 1234, 
    	para poder gestionar los empleados y todas las funcionalidades.

    	Si quieres acceder como nutricionista, podrás acceder con el usuario nutri@nutri.com y la contraseña 1234,
    	puedes crear servicios a perros de los servicios SVNUT.

    	Si quieres acceder como auxiliar, podrás acceder con el usuario auxiliar@auxiliar.com y la contraseña 1234, 
    	con funcionalidades restringidas.

    	Si quieres acceder como estilista, podrás acceder con el usuario esti@esti.com y la contraseña 1234,
   	puedes crear servicios a perros de los servicioS SVBE.

    	Si quieres acceder como att.cliente, podrás acceder con el usuario attcliente@attcliente.com y la contraseña 1234,
    	no puedes gestionar a los empleados.