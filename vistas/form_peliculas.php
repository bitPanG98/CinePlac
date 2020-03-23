<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> * Modulo de Peliculas * </title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/personalizar/personalizar.css">

        <script src="../js/validacion.js"></script>
    </head>
    <body>

<div>
            <form id="form_peliculas" name="form_peliculas" method="post" action="../modelos/gestionar_pelicula.php" enctype="multipart/form-data">
                <input type="hidden" name="accion" value="registrar">

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
                            <input type="text" name="caja_nombre" id="caja_nombre" autocomplete="off" class="form-control" style="width: 200px; height: 30px;" required>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Duracion :
                        </td>
                        <td>
                            <input type="time" name="caja_duracion" id="caja_duracion"  class="form-control" style="width: 90px; height: 30px;"  required>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Descripcion :
                        </td>
                        <td>
                            <input type="text" name="caja_descripcion" id="caja_descripcion" autocomplete="off" class="form-control" style="width: 200px; height: 30px;"  required>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Stock :
                        </td>
                        <td>
                            <input type="number" value="1" min="1" name="caja_stock" id="caja_stock" autocomplete="off" class="form-control" style="width: 100px; height: 30px;"  required>
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
                            <input type="text" name="caja_precio" id="caja_precio" onkeypress="return SoloNumeros(event,this);" autocomplete="off" class="form-control" style="width: 200px; height: 30px;"  required>
                        </td>
                    </tr>

                    <tr>
                    	<td  align="right" height="50px">
                    		Imagen :
                    	</td>
                    	<td>
                    		<input type="file" name="imagenP" id="imagenP"  class="form-control" inputmode="" >
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
                            <input type="submit" name="registrar"  class="btn btn-danger"  value="Registrar">
                            <input type="button" name="cancelar" value="Cancelar" class="btn btn-danger" onclick="location.href = '../vistas/form_menu.php'">
                        </td>
                    </tr>

                </table>
            </form>
        </div>

        <div>

        </div>
        <br>         
        <div>
            <table width="70%" align="center" border="1" style="border-collapse: collapse;" bgcolor='#85F5DB'>
                <tr height="30px" align="center" bgcolor="#3799A9">
                    <td align="center">
                        Nombre
                    </td>
                    <td align="center" width="8%">
                        Duracion
                    </td>
                    <td align="center">
                        Descripcion
                    </td>
                    <td align="center" width="8%">
                        Stock
                    </td>
                    <td align="center" width="8%">
                        Genero
                    </td>
                    <td align="center" width="8%">
                        Precio
                    </td>
                    <td align="center" width="8%">
                        Imagen
                    </td>
                    <td align="center" width="10%" >
                        Estado
                    </td>
                    <td align="center" width="8%">
                        ..
                    </td>

                </tr>

                 <?php
                    //incluimos la conexion a BD
                    require_once("../modelos/config.php");
                    $conexion = conectarBD();

                    //consulta para cargar los datos
                    $sqlListarPeliculas = "SELECT p.cod_pelicula, p.nombre, p.duracion, p.descripcion, p.stock, gp.nombre_gp, p.precio, p.estado, p.imagen  "
                            . "FROM peliculas p, generos_peliculas gp "
                            . "WHERE p.cod_generopelicula = gp.cod_generopelicula ";

                    $resultado = $conexion->query($sqlListarPeliculas);
                ?>

                <?php
                    while ($col = $resultado->fetch_object()) {
                ?>

                <tr>
                    <td align="center">
                    	<?php echo $col->nombre; ?>
                    </td>
                    <td align="center">
                    	<?php echo $col->duracion; ?>
                    </td>
                    <td>
                        <P align="justify">
                        	<?php echo $col->descripcion; ?>
                        </P>
                    </td>
                    <td align="center">
                    	<?php echo $col->stock; ?>
                    </td>
                    <td align="center">
                    	<?php echo $col->nombre_gp; ?>
                    </td>
                    <td align="center">
                    	<?php echo $col->precio; ?>
                    </td>
                    <td align="center">
                        <?php
                                echo "<img WIDTH='50px' HEIGHT='50px' src='data:imagen/jpeg;base64,".base64_encode($col->imagen). "' />";
                        ?>
                    </td>
                    <td align="center">
                    	<?php                                
                    			 $estado = $col->estado;
                                if ($estado==1) {
                                    echo 'Activo';
                                }else{
                                    echo 'Inactivo';
                                }  
                         ?>
                    </td>
                    <td align="center">
                    	    <a href="../modelos/gestionar_pelicula.php?id=<?php echo $col->cod_pelicula ?>&accion=darBaja">
                                <image src="../imagenes/iconos/darbaja.png" width="30px" height="25px"/>
                            </a>
                            <a href="../vistas/form_modificarpelicula.php?id=<?php echo $col->cod_pelicula ?>">
                                <image src="../imagenes/iconos/modificar.png" width="30px" height="25px"/>
                            </a>
                    </td>
                </tr>
 			
 			    <?php
                 	}
                ?>
            </table>
        </div>

        <dir>
        	<br>
        </dir>

    </body>
</html>
