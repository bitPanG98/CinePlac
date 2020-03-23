<?php

verificarSubmit();

//Funcion para registrar ciente en la BD
function registarCliente() {

    require_once '../modelos/config.php';
    $conexion = conectarBD();

    $codigo = getCodigoCliente();
    $dni = mysqli_escape_string($conexion, $_POST['caja-dniC']);
    $nombre = mysqli_escape_string($conexion, $_POST['caja-nombreC']);
    $apellidos = mysqli_escape_string($conexion, $_POST['caja-apellidosC']);
    $password = mysqli_escape_string($conexion, md5($_POST['caja-password']));

    $sqlGetUserDNI = mysqli_query($conexion, "SELECT * FROM clientes WHERE dni_cliente='$dni'");
    $numerorows = mysqli_num_rows($sqlGetUserDNI);

    if ($numerorows == 0) {

        //consultas
        $sqlRegistrarCliente = "INSERT INTO clientes VALUES('$codigo','$dni','$nombre','$apellidos','1')";
        

        //Ejecutamos la consulta.
        $guardarCliente = mysqli_query($conexion, $sqlRegistrarCliente);

        //Comprobamos que se ejecuto correctamente.
        if (!$guardarCliente) {
            // mostramos mensaje si ocurre un error 
            printf("Error en ejecutar sentencia: %s\n", mysqli_error($conexion));
        } else {
            
            $sqlRegistrarUsuario = "INSERT INTO usuarios VALUES(NULL,'$dni','$password','Cliente','$codigo','1')";
            $guardarUsuario = mysqli_query($conexion, $sqlRegistrarUsuario);
            if (!$guardarUsuario) {
                printf("Error en ejecutar sentencia: %s\n", mysqli_error($conexion));
            } else {

                echo'<script>
                  alert("Datos Guardados Satisfactoriamente :)");
                 </script>';

                require_once '../vistas/form_suscribirse.php';
                //cerramos la conexion 
                mysqli_close($conexion);
            }
        }
        
    } else {
        echo "<script> alert('Ya se encuentra registrado un usuario con El Nº DNI'); </script>";
        require_once '../vistas/form_suscribirse.php';
    }
}

//Verificar todo este correcto en los inputs
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
                require_once '../vistas/form_suscribirse.php';
            }
        } else {

            echo "<script> alert('Debe completar todos los campos'); </script>";
            require_once '../vistas/form_suscribirse.php';
        }
    }
}

//Funcion para obtener el codigo del cliente
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
?>

