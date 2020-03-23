<?php

//-----------------------------Verificar todo este correcto en los inputs-------------------------------------------
function verificarSubmit() {

    if (isset($_POST['registrar'])) {

        $nombre = $_POST['caja_nombre'];
        $duracion = $_POST['caja_duracion'];
        $descripcion = $_POST['caja_descripcion'];
        $stock = $_POST['caja_stock'];
        $genero = $_POST['combo_genero'];
        $precio = $_POST['caja_precio'];
        $url_video= $_POST['caja_urlvideo'];
       
            if (strlen($nombre) > 3 ) {
                    /*$url_serverpeli = strpos($url_video, "https://ok.ru/video/");
                    if ($url_serverpeli !== false) {
                    }else {
                            echo "<script> alert('La url del video debe ser del sitio :  http://gnula.nu \n'); </script>";
                            require_once('../vistas/form_peliculas.php');
                    }*/
                        if (is_uploaded_file($_FILES['imagenP'] ['tmp_name'])) {

                                $limiteKB = 16384;
                                $formatoPermitidos = array("image/jpg" , "image/jpeg" , "image/gif" , "image/png" , "image/bmp" , "");

                                if (in_array($_FILES['imagenP']['type'] , $formatoPermitidos) && $_FILES['imagenP']['size'] <= $limiteKB*1024) {
                                    
                                    registarPelicula();

                                }else{
                                     echo "<script> alert('Porfavor seleccione un archivo imagen'); </script>";
                                     require_once('../vistas/form_peliculas.php');
                                }

                        }else{
                                echo "<script> alert('Porfavor seleccione la imagen a subir'); </script>";
                                require_once('../vistas/form_peliculas.php');
                        }
                
            } else {
                echo "<script> alert('El nombre de la pelicula debe tener mas de 3 caracteres'); </script>";
                require_once('../vistas/form_peliculas.php');
            }

    }
}

//----------------------------Funcion para registrar ciente en la BD--------------------------
function registarPelicula() {

    require_once '../modelos/config.php';
    $conexion = conectarBD();

    if (isset( $_POST['caja_nombre']) || isset( $_POST['caja_duracion']) || isset( $_POST['caja_descripcion']) ||  isset( $_POST['caja_stock'])) {

        $nombre = $_POST['caja_nombre'];
        $duracion = $_POST['caja_duracion'];
        $descripcion = $_POST['caja_descripcion'];
        $stock = $_POST['caja_stock'];
        $genero = $_POST['combo_genero'];
        $precio = $_POST['caja_precio'];
        $url_video= $_POST['caja_urlvideo'];
        
        /*//https://ok.ru/videoembed/1164295670387?autoplay=1
        $url_modificada = str_replace("video", "videoembed", $url_video);
        $embed_video="<iframe width='560' height='315' src='".$url_modificada."?autoplay=1' frameborder='0' allow='autoplay' allowfullscreen></iframe>";*/

        $imagenP=$conexion->real_escape_string(file_get_contents($_FILES["imagenP"]["tmp_name"]));
        $tipo = $_FILES['imagenP']['type'];

        //consuta para ejecutar en BD
        $sqlRegistrarPelicula = " INSERT INTO peliculas VALUES(null, '$nombre', '$duracion' , '$descripcion' , '$stock' , '$genero' , '$precio' , '$imagenP', '$url_video', 1) ";        
        //Ejecutamos la consulta.
        $guardarPelicula = mysqli_query($conexion, $sqlRegistrarPelicula);

        //Comprobamos que se ejecuto correctamente.
        if (!$guardarPelicula) {
                // mostramos mensaje si ocurre un error 
               printf("Error en ejecutar sentencia: %s\n", mysqli_error($conexion));
        } else {

                echo'<script>
                      alert("Datos Guardados Satisfactoriamente :)");
                     </script>';

                require_once('../vistas/form_peliculas.php');
        }

    }
    
}

function darBajaPelicula() {

    //incluimos la conexion a BD
    require_once("../modelos/config.php");
    $conexion = conectarBD();

    $codigoPelicula = $_GET['id'];

    $sqlDarBajaPelicula = "UPDATE peliculas SET estado=0 WHERE cod_pelicula='$codigoPelicula'";
    $respuesta = $conexion->query($sqlDarBajaPelicula);
    if (!$respuesta) {
        echo "error: " . $conexion->error;
    } else {
        echo "<script> alert('Datos de pelicula dados de baja oorrectamente'); </script>";
        require_once('../vistas/form_peliculas.php');
    }
}


if (isset($_GET['accion']) == "darBaja") {
    darBajaPelicula();
}  else if (isset($_POST['accion']) == "registrar") {
    verificarSubmit();
}

?>

