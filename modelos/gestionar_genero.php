
<?php

//-----------------------------Verificar todo este correcto en los inputs-------------------------------------------
function verificarSubmit() {

    if (isset($_POST['registrar'])) {

        $nombre = strtoupper(trim($_POST['caja_nombre']));
        $descripcion = strtoupper(trim($_POST['caja_descripcion']));
       
            if (strlen($nombre) > 3) {

                registarGenero();

            } else {

                echo "<script> alert('Debe ingresar un nombre valido , con mas letras'); </script>";
                require_once('../vistas/form_generos.php');
            }


    }
}

//----------------------------Funcion para registrar ciente en la BD--------------------------
function registarGenero() {

    require_once '../modelos/config.php';
    $conexion = conectarBD();

    $nombre = mysqli_escape_string($conexion, strtoupper(trim($_POST['caja_nombre'])));
    $descripcion = mysqli_escape_string($conexion, strtoupper(trim($_POST['caja_descripcion'])));

    $sqlGetNombre = mysqli_query($conexion, "SELECT * FROM generos_peliculas WHERE nombre_gp='$nombre'");
    $numerorows = mysqli_num_rows($sqlGetNombre);

    if ($numerorows == 0) {

        //consultas
        $sqlRegistrarGenero = "INSERT INTO generos_peliculas VALUES(null,'$nombre','$descripcion','1')";

        //Ejecutamos la consulta.
        $guardarGenero = mysqli_query($conexion, $sqlRegistrarGenero);

        //Comprobamos que se ejecuto correctamente.
        if (!$guardarGenero) {
            // mostramos mensaje si ocurre un error 
            printf("Error en ejecutar sentencia: %s\n", mysqli_error($conexion));
        } else {

                echo'<script>
                  alert("Datos Guardados Satisfactoriamente :)");
                 </script>';

                require_once('../vistas/form_generos.php');
            
        }
        
    } else {
        echo "<script> alert('Ya se encuentra registrado un genero de pelicula con el mismo nombre :) '); </script>";
        require_once('../vistas/form_generos.php');
    }
}


function darBajaGenero() {

    //incluimos la conexion a BD
    require_once("../modelos/config.php");
    $conexion = conectarBD();

    $codigoGenero = $_GET['id'];

    $sqlDarBajaGenero = "UPDATE generos_peliculas  SET estado=0 WHERE  cod_generopelicula='$codigoGenero'";
    $respuesta = $conexion->query($sqlDarBajaGenero);
    if (!$respuesta) {
        echo "error: " . $conexion->error;
    } else {
        echo "<script> alert('Datos de Genero dados de baja oorrecamente'); </script>";
        require_once('../vistas/form_generos.php');
    }
}

//----------COMANDOS  ENVIADOS DESDE FORMULARIO------------------

    if (isset($_GET['accion']) == "darBaja") {
        darBajaGenero();
    }  else if (isset($_POST['accion']) == "registrar") {
        verificarSubmit();
    }


?>