<!DOCTYPE html>

<?php
        //Inicia una nueva sesión o reanuda la existente 
        session_start();
        if (isset($_SESSION['usuario_acceso'])) {
           header("Location: ../vistas/form_modificarpelicula.php");
        } else {
            header("Location: ../vistas/form_login.php");
        }

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> * Modulo de Peliculas * </title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/personalizar/personalizar.css">

        <script src="../js/validacion.js"></script>
    </head>
    <body>

<?php
	
        	//================================================================================================================
            if (isset($_GET)) {

                     //incluimos la conexion a BD
                    require_once("../modelos/config.php");
                    $conexion = conectarBD();
               
                    $codigoP = $_GET['id'];
                    $nombreP="";
                    $duracionP="";
                    $descripcionP="";
                    $stockP="";
                    $generoP ="";
                    $precioP="";
                    $imagenP="";
                    $estadoP="";

                    //----------------------------
                    $seleccionarEstadoA="";
                    $seleccionarEstadoI="";

                    //consulta para cargar los datos
                    $sqlListarPeliculas = "SELECT  p.cod_pelicula, p.nombre, p.duracion, p.descripcion, p.stock, gp.nombre_gp, p.precio, p.imagen, p.estado  "
                            . "FROM  peliculas p, generos_peliculas gp "
                            . "WHERE  p.cod_generopelicula = gp.cod_generopelicula AND p.cod_pelicula ='$codigoP' ";

                    $resultadoP = $conexion->query($sqlListarPeliculas);
                    
                    while ($colP = $resultadoP->fetch_object()) {
                        $nombreP = $colP->nombre;
                        $duracionP = $colP->duracion;
                        $descripcionP= $colP->descripcion;
                        $stockP = $colP->stock;
                        $generoP = $colP->nombre_gp;
                        $precioP = $colP->precio;
                        $imagenP = $colP->imagen;
                        $estadoP=$colP->estado;
                    }

                    if ($estadoP==1) {
                        $seleccionarEstadoA="selected";
                    }else if ($estadoP==0) {
                         $seleccionarEstadoI="selected";
                    }{
                        $seleccionarEstadoA="";
                    }

            }
           

            //======================================================================================================
            if ($_POST) {

					        $nombre = $_POST['caja_nombre'];
					        $duracion = $_POST['caja_duracion'];
					        $descripcion = $_POST['caja_descripcion'];
					        $stock = $_POST['caja_stock'];
					        $genero = $_POST['combo_genero'];
					        $precio = $_POST['caja_precio'];
                            $url_video= $_POST['caja_urlvideo'];

					            if (strlen($nombre) > 3 ) {
					              
					                if (is_uploaded_file($_FILES['imagenP'] ['tmp_name'])) {

					                        $limiteKB = 16384;
					                        $formatoPermitidos = array("image/jpg" , "image/jpeg" , "image/gif" , "image/png" , "image/bmp" , "");

					                        if (in_array($_FILES['imagenP']['type'] , $formatoPermitidos) && $_FILES['imagenP']['size'] <= $limiteKB*1024) {
					                            
					                            modificarPelicula();

					                        }else{
					                             echo "<script> alert('Porfavor seleccione un archivo imagen'); </script>";
					                             require_once('../vistas/form_modificarpelicula.php');
					                        }

					                }else{
					                        echo "<script> alert('Porfavor seleccione la imagen a subir'); </script>";
					                        require_once('../vistas/form_modificarpelicula.php');
					                }

					                
					            } else {

					                echo "<script> alert('El nombre de la pelicula debe tener mas de 3 caracteres'); </script>";
					                require_once('../vistas/form_modificarpelicula.php');
					            }

            }


            	//----------------------------Funcion para registrar ciente en la BD--------------------------
		function modificarPelicula() {

		    require_once '../modelos/config.php';
		    $conexion = conectarBD();

		    if (isset( $_POST['caja_nombre']) || isset( $_POST['caja_duracion']) || isset( $_POST['caja_descripcion']) ||  isset( $_POST['caja_stock'])) {

		    	$codigoP = $_GET['id'];
		        $nombre = $_POST['caja_nombre'];
		        $duracion = $_POST['caja_duracion'];
		        $descripcion = $_POST['caja_descripcion'];
		        $stock = $_POST['caja_stock'];
		        $genero = $_POST['combo_genero'];
		        $precio = $_POST['caja_precio'];
                $url_video= $_POST['caja_urlvideo'];
		        $estado = $_POST['cbEstado'];


		        $imagenP=$conexion->real_escape_string(file_get_contents($_FILES["imagenP"]["tmp_name"]));
		        $tipo = $_FILES['imagenP']['type'];

		        //consuta para ejecutar en BD
		        $sqlModificarPelicula = "UPDATE peliculas SET nombre='$nombre', duracion='$duracion', descripcion='$descripcion', stock='$genero', cod_generopelicula='$genero', precio='$precio', imagen='$imagenP', url_video='$url_video', estado='$estado' WHERE cod_pelicula='$codigoP' ";
		        //Ejecutamos la consulta.
		        $modificarPelicula = mysqli_query($conexion, $sqlModificarPelicula);

		        //Comprobamos que se ejecuto correctamente.
		        if (!$modificarPelicula) {
		                // mostramos mensaje si ocurre un error 
		               printf("Error en ejecutar sentencia: %s\n", mysqli_error($conexion));
		        } else {

		                echo'<script>
		                      alert("Datos de plicula modificados Satisfactoriamente :)");
		                     </script>';

		                header('Location: ../vistas/form_peliculas.php');
		        }

		    }
		    
		}
     
        ?>

<div>
            <form id="form_peliculas" name="form_peliculas" method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="accion" value="modificar">

                <table align="center"  width="30%" bgcolor='#85F5DB' class="">
                    <tr>
                        <td align="center" colspan="2" height="60px" bgcolor="#3799A9">
                              <h4> Modulo  *  Peliculas * </h4>
                            <image src="../imagenes/pelicula.png" width="50px" height="50px"/> 
                            <br>
                        </td>
                    </tr>

                    <tr height="50px" >
                        <td align="right" height="50px">
                            Nombre :
                        </td>
                        <td>
                            <input type="text" name="caja_nombre" id="caja_nombre" value=" <?php echo $nombreP; ?> " autocomplete="off" class="form-control" style="width: 200px; height: 30px;" required>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Duracion :
                        </td>
                        <td>
                            <input type="time" value=" <?php echo $duracionP; ?> " name="caja_duracion" id="caja_duracion"   class="form-control" style="width: 90px; height: 30px;"  required>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Descripcion :
                        </td>
                        <td>
                            <input type="text" name="caja_descripcion" id="caja_descripcion" value=" <?php echo $descripcionP; ?> "  autocomplete="off" class="form-control" style="width: 200px; height: 30px;"  required>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Stock :
                        </td>
                        <td>
                            <input type="number" min="1" name="caja_stock" id="caja_stock" value=" <?php echo $stockP; ?> "  autocomplete="off" class="form-control" style="width: 100px; height: 30px;"  required>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Genero :
                        </td>

                        <td>
                            <select name="combo_genero" id="combo_genero" class="form-control" style="width: 200px; height: 30px;" >
                            
                            <?php
                                //incluimos la conexion a BD
                                require_once("../modelos/config.php");
                                $conexion = conectarBD();

                                //consulta para cargar los datos
                                $sqlListarGeneros = "SELECT  cod_generopelicula, nombre_gp "
                                        . "FROM generos_peliculas "
                                        . "WHERE estado=1 ";

                                $result = $conexion->query($sqlListarGeneros);

                                while ($col1 = $result->fetch_object()) {
                            ?>
                                <option value='<?php echo $col1->cod_generopelicula; ?>'>
                                    <?php 
                                         echo $col1->nombre_gp;
                                    ?>
                                </option>  

                            <?php
                                }
                            ?>  
                            </select>
                        </td>

                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Precio :
                        </td>
                        <td>
                            <input type="text" name="caja_precio" id="caja_precio" value=" <?php echo $precioP; ?> "  onkeypress="return SoloNumeros(event,this);" autocomplete="off" class="form-control" style="width: 200px; height: 30px;"  required>
                        </td>
                    </tr>

                    <tr>
                        <td  align="right" height="50px">
                            Imagen :
                        </td>
                        <td>
                            <input type="file" name="imagenP" id="imagenP"  class="form-control" inputmode="">
                        </td>
                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Estado :
                        </td>
                        <td>
                            <select id="cbEstado" name="cbEstado">
                                <option value="1" <?php echo $seleccionarEstadoA; ?> >
                                    Activo
                                </option>
                                <option value="0"  <?php echo $seleccionarEstadoI; ?> >
                                    Inactivo
                                </option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="right" height="50px">
                            Url video :
                        </td>
                        <td>
                            <input type="text" name="caja_urlvideo" id="caja_urlvideo" autocomplete="off" class="form-control" style="width: 200px; height: 30px;"  required>
                        </td>
                    </tr>

                    <tr bgcolor="#6C84E8">
                        <td colspan="2" align="center" height="50px" width='45%'  >
                            <input type="submit" name="modificar"  class="btn btn-danger"  value="Modificar">
                            <input type="button" name="cancelar" value="Cancelar" class="btn btn-danger" onclick="location.href = '../vistas/form_peliculas.php'">
                        </td>
                    </tr>

                </table>
            </form>
        </div>

        <dir>
            <br>
        </dir>

    </body>
</html>
