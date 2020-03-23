<?php

//-----------------------------Verificar todo este correcto en los inputs-------------------------------------------
function verificarSubmit() {

    if (isset($_POST['registrar'])) {

        $codigo = getCodigoCliente();
        $dni = $_POST['caja-dniC'];
        $nombre = $_POST['caja-nombreC'];
        $apellidos = $_POST['caja-apellidosC'];
        $password = md5($_POST['caja-password']);

        if (empty($dni) || empty($nombre) || empty($apellidos) || empty($usuario) || empty($password)) {

            if (strlen($dni) == 8) {

                registarCliente();
            } else {

                echo "<script> alert('El Nº DNI, debe tenr 8 caracteres'); </script>";
                require_once('../vistas/form_clientes.php');
            }
        } else {

            echo "<script> alert('Debe completar todos los campos'); </script>";
            require_once('../vistas/form_clientes.php');
        }
    }
}

//----------------------------Funcion para registrar ciente en la BD--------------------------
function registarCliente() {

    require_once '../modelos/config.php';
    $conexion = conectarBD();

    $codigo = getCodigoCliente();
    $dni = mysqli_escape_string($conexion, $_POST['caja-dniC']);
    $nombre = mysqli_escape_string($conexion, strtoupper($_POST['caja-nombreC']));
    $perfil = mysqli_escape_string($conexion, $_POST['perfil']);
    $apellidos = mysqli_escape_string($conexion, strtoupper($_POST['caja-apellidosC']));
    $password = mysqli_escape_string($conexion, md5($_POST['caja-password']));

    $sqlGetUserDNI = mysqli_query($conexion, "SELECT * FROM clientes WHERE dni_cliente='$dni'");
    $numerorows = mysqli_num_rows($sqlGetUserDNI);

    if ($numerorows == 0) {

        //consultas
        $sqlRegistrarCliente = "INSERT INTO clientes VALUES('$codigo','$dni','$nombre','$apellidos','1')";
        $sqlRegistrarUsuario = "INSERT INTO usuarios VALUES(NULL,'$dni','$password','$perfil','$codigo','1')";

        //Ejecutamos la consulta.
        $guardarCliente = mysqli_query($conexion, $sqlRegistrarCliente);

        //Comprobamos que se ejecuto correctamente.
        if (!$guardarCliente) {
            // mostramos mensaje si ocurre un error 
            printf("Error en ejecutar sentencia: %s\n", mysqli_error($conexion));
        } else {

            $guardarUsuario = mysqli_query($conexion, $sqlRegistrarUsuario);
            if (!$guardarUsuario) {
                printf("Error en ejecutar sentencia: %s\n", mysqli_error($conexion));
            } else {

                echo'<script>
                  alert("Datos Guardados Satisfactoriamente :)");
                 </script>';

                require_once('../vistas/form_clientes.php');
            }
        }
    } else {
        echo "<script> alert('Ya se encuentra registrado un usuario con El Nº DNI'); </script>";
        require_once('../vistas/form_clientes.php');
    }
}

//----------------------Funcion para obtener el codigo del cliente-------------------------------
function getCodigoCliente() {

    require_once '../modelos/config.php';
    $conexion = conectarBD();

    $codigoCliente = 0;

    $sqlGetCodigoCliente = "SELECT cod_cliente FROM clientes";

    //usamos la conexion para dar un resultado a la variable
    $resultado = $conexion->query($sqlGetCodigoCliente);

    //obtenemos el numero de filas del resultado obtenido 
    $filas = $resultado->num_rows;

    if ($filas > 0) {
        while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
            $codigoCliente = $row['cod_cliente'] + 1;
        }
    }

    return $codigoCliente;
}

//------------------------------------------FUNCION PARA LISTAR CLIENTES--------------------------------------------------------------
function listarClientes() {

    //incluimos la conexion a BD
    require_once("../modelos/config.php");
    $conexion = conectarBD();

    //consulta para cargar los datos
    $sqlListarClientes = "SELECT c.dni_cliente, c.nombre_cliente, c.apellidos_cliente, u.dni_user, u.perfil  "
            . "FROM clientes c, usuarios u "
            . "WHERE c.cod_cliente=u.cod_cliente";

    //obtenemos los resultados de la consulta
    $cargarDatos = mysqli_query($conexion, $sqlListarClientes);


    //recorremos todos los registros y los vamos mostrando
    while ($filas = mysqli_fetch_array($cargarDatos)) {

        echo "<td> 
		$filas[dni_cliente]
    	      </td>";
        echo "<td> 
		$filas[nombre_cliente]
    	      </td>";
        echo "<td> 
		$filas[apellidos_cliente]
    	      </td>";
        echo "<td> 
		$filas[dni_user]
    	      </td>";
        echo "<td> 
    	  	$filas[perfil] 
    	      </td>";
        echo "<td> 
    	  	$filas[estado_cliente] 
    	      </td>";
    }

    //obtenemos la cantidad de registros de la tabla
    $numeroRegistros = mysqli_num_rows($cargarDatos);
    //mostramos el total de registros
    echo " <center>  Nª Clientes : $numeroRegistros </center>";
}

function darBajaCliente() {

    //incluimos la conexion a BD
    require_once("../modelos/config.php");
    $conexion = conectarBD();

    $codigoCliente = $_GET['id'];

    $sql = "UPDATE clientes c, usuarios u SET c.estado_cliente=0, u.estado_user=0 WHERE c.cod_cliente=u.cod_cliente AND c.cod_cliente='$codigoCliente'";
    $respuesta = $conexion->query($sql);
    if (!$respuesta) {
        echo "error: " . $conexion->error;
    } else {
        echo "<script> alert('Datos de cliente dados de baja oorrecamente'); </script>";
        require_once('../vistas/form_clientes.php');
    }
}


if (isset($_GET['accion']) == "darBaja") {

    darBajaCliente();
    
}  else if (isset($_POST['accion']) == "registrar") {

    verificarSubmit();

}

?>

