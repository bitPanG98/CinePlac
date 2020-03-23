
<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> *Modulo de Generos Peliculas* </title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/personalizar/personalizar.css">

         <script src="../js/validacion.js"></script>

    </head>
    <body>
        <div>
            <form id="form_generos" name="form_generos" method="post" action="../modelos/gestionar_genero.php">
                <input type="hidden" name="accion" value="registrar">
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
                            <input type="text" name="caja_nombre" id="caja_nombre"  autocomplete="off" class="form-control" style="width: 200px; height: 30px;" required >
                        </td>
                    </tr>

                    <tr>
                        <td align="right" height="50px">
                            Descripcion :
                        </td>
                        <td>
                            <input type="text" name="caja_descripcion" id="caja_descripcion" autocomplete="off" class="form-control" style="width: 200px; height: 30px;" required >
                        </td>
                    </tr>

                    <tr bgcolor="#6C84E8">
                        <td align="center" height="50px" colspan="2">
                            <input type="submit" name="registrar"id="registrar" class="btn btn-danger" value="Registrar">
                            <input type="button" name="cancelar" value="Cancelar" class="btn btn-danger" value="Cancelar" onclick="location.href = '../vistas/form_menu.php' ">
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div>

        </div>
        <br>         
        <div>
            <table width="60%" align="center" border="1" style="border-collapse: collapse;" bgcolor="#3799A9">
                <tr height="25px" bgcolor="#3799A9">
                    <td align="center" width="10%">
                        Nombre
                    </td>
                    <td align="center">
                        Descripcion
                    </td>
                    <td align="center" width="10%">
                        Estado
                    </td>
                    <td align="center" width="15%" >
                        ..
                    </td>
                </tr>


                <?php
                    //incluimos la conexion a BD
                    require_once("../modelos/config.php");
                    $conexion = conectarBD();

                    //consulta para cargar los datos
                    $sqlListarGeneros = "SELECT  * "
                            . "FROM  generos_peliculas";

                    $resultado = $conexion->query($sqlListarGeneros);
                ?>

                <?php
                    while ($col = $resultado->fetch_object()) {
                ?>

                <tr>
                    <td align="center">
                    	 <?php echo $col->nombre_gp ?>
                    </td>
                    <td>
                        <P align="justify">
                        	 <?php echo $col->descripcion_gp ?>
                        </P>
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
                    	<a href="../modelos/gestionar_genero.php?id=<?php echo $col->cod_generopelicula ?>&accion=darBaja">
                                <image src="../imagenes/iconos/darbaja.png" width="30px" height="25px"/>
                         </a>
                         <a href="../vistas/form_modificargeneros.php?id=<?php echo $col->cod_generopelicula ?>">
                                <image src="../imagenes/iconos/modificar.png" width="30px" height="25px"/>
                         </a>
                    </td>
                </tr>

                 <?php
                 	}
                ?>
 
            </table>
        </div>
    </body>
</html>
