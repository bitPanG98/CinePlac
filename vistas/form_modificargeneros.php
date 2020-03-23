<!DOCTYPE html>

<?php
        //Inicia una nueva sesión o reanuda la existente 
        session_start();
        if (isset($_SESSION['usuario_acceso'])) {
           header("Location: ../vistas/form_modificargeneros.php");
        } else {
            header("Location: ../vistas/form_login.php");
        }

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> *Modulo de Generos Peliculas* </title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/personalizar/personalizar.css">

         <script src="../js/validacion.js"></script>

    </head>
    <body>

    <?php

            //Paa cargar los datos al los inputs
            if (isset($_GET)) {

                     //incluimos la conexion a BD
                    require_once("../modelos/config.php");
                    $conexion = conectarBD();
               
                    $codigoG = $_GET['id'];
                    $nombreG="";
                    $descripcionG="";
                    $estadoG="";
                    $seleccionado1="";
                    $seleccionado2="";
                                      
                    //consulta para cargar los datos
                    $sqlListarGeneros = "SELECT * "
                            . "FROM  generos_peliculas "
                            . "WHERE cod_generopelicula='$codigoG'";

                    $resultadoG = $conexion->query($sqlListarGeneros);
                    
                    while ($colG = $resultadoG->fetch_object()) {

                        $nombreG = $colG->nombre_gp;
                        $descripcionG= $colG->descripcion_gp;
                        $estadoG = $colG->estado;

                    }

                    if ($estadoG=="1") {
                        $seleccionado1 = "selected=''";
                    }else if ($estadoG=="0") {
                        $seleccionado2="selected=''";
                    }else{
                        $seleccionado="";
                    }

            }
           
            //Para modificar los datos          
            if ($_POST) {


                         //incluimos la conexion a BD
                        require_once("../modelos/config.php");
                        $conexion = conectarBD();

                        $codigo = $_GET['id'];
                        $nombre = strtoupper(trim($_POST['caja_nombre']));
                        $descripcion = strtoupper(trim($_POST['caja_descripcion']));
                        $estado = mysqli_escape_string($conexion, $_POST['cbEstado']);
                        
                        if (strlen($nombre) > 3) {

                                        $sqlModificarGenero = "UPDATE generos_peliculas "
                                        . "SET nombre_gp='$nombre', "
                                        . " descripcion_gp='$descripcion', "
                                        . " estado='$estado' "
                                        . "WHERE  cod_generopelicula='$codigo'";

                                        $respuesta = mysqli_query($conexion, $sqlModificarGenero);
                                        if (!$respuesta) {
                                            printf("Error en ejecutar sentencia: %s\n", mysqli_error($conexion));
                                        } else {
                                            header('Location: ../vistas/form_generos.php');
                                            echo "<script> alert('Datos de genero modificados oorrecamente'); </script>";
                                        }

                        } else {
                            echo "<script> alert('Debe ingresar un nombre valido , con mas letras'); </script>";
                            require_once('../vistas/form_generos.php');
                        }                

            }
   
        ?>


          <div>
            <form id="form_generos" name="form_generos" method="post" action="">
                <input type="hidden" name="accion" value="modificar">
                <table align="center"  width="30%" bgcolor='#85F5DB'>
                    <tr>
                        <td height="50px" align="center" colspan="2" bgcolor="#3799A9">
                            <br>
                            <h4>  Modulo "Generos de Peliculas" </h4>
                            <image src="../imagenes/generopeli.png" width="50px" height="50px"/> 
                        </td>
                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Nombre :
                        </td>
                        <td>
                            <input type="text" name="caja_nombre" id="caja_nombre"  value="<?php  echo $nombreG;?>" autocomplete="off" class="form-control" style="width: 200px; height: 30px;" required >
                        </td>
                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Descripcion :
                        </td>
                        <td>
                            <input type="text" name="caja_descripcion" id="caja_descripcion" value="<?php  echo $descripcionG;?>" autocomplete="off" class="form-control" style="width: 200px; height: 30px;" required >
                        </td>
                    </tr>

                    <tr>
                        <td  align="right" height="50px">
                            Estado :
                        </td>    
                        <td>
                            <select name="cbEstado" id="cbEstado" >
                                <option value="1" <?php echo $seleccionado1?> >
                                    Activo
                                </option>
                                <option value="0" <?php echo $seleccionado2?> >
                                    Inactivo
                                </option>
                            </select>
                        </td>
                    </tr>

                    <tr bgcolor="#6C84E8">
                        <td align="center" height="50px" colspan="2">
                            <input type="submit" name="modificar"id="registrar" class="btn btn-danger" value="Modificar">
                            <input type="button" name="cancelar" value="Cancelar" class="btn btn-danger" value="Cancelar" onclick="location.href = '../vistas/form_menu.php' ">
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    </body>
</html>
