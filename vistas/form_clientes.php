<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> * Modulo de Cliente * </title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/personalizar/personalizar.css">

        <script src="../js/validacion.js"></script>
    </head>

    <body>

        <div>    
            <form id="form-suscribirse" name="form-suscribirse" method="post" action="../modelos/gestionar_cliente.php">

                <input type="hidden" name="accion" value="registrar">

                <table border="0" align="center" width="40%" bgcolor='#85F5DB'>
                    <tr>
                        <td align="center" colspan="2" height="50px" bgcolor="#3799A9">
                            <h4> * Modulo de Clientes * </h4>
                            <image src="../imagenes/cliente.png" width="50px" height="50px"/> 
                        </td>
                    </tr>

                    <tr>
                        <td align="right" width='30%' height='50px' >
                            DNI :
                        </td>
                        <td width='55%'>
                            <input type="text" id="caja-dniC" name="caja-dniC"  maxlength="8" autocomplete="off" class="form-control"  style="width: 200px; height: 30px;" onKeyPress="return SoloNumeros(event);" onkeyup="obtenerValorDNI(event);" required="">
                        </td>
                    </tr>

                    <tr>
                        <td align="right" width='45%' height='50px' >
                            Nombre(s) :  
                        </td>
                        <td width='55%'>
                            <input type="text" id="caja-nombreC" name="caja-nombreC" autocomplete="off" class="form-control" style="width: 200px; height: 30px;" onkeypress="return soloLetras(event);" required>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" width='45%' height='50px' >
                            Apellidos :
                        </td>
                        <td>
                            <input type="text" id="caja-apellidosC" name="caja-apellidosC" autocomplete="off" class="form-control" style="width: 200px; height: 30px;" onkeypress="return soloLetras(event);" required>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="right" width='45%' height='50px' >
                            Perfil :
                        </td>
                        <td>
                            <select id="perfil" name="perfil">
                                <option value="Cliente">Cliente</option>
                                <option value="Vendedor">Vendedor</option>
                                <option value="Adminstrador">Administrador</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="right" width='45%' height='50px' >
                            Usuario :
                        </td>
                        <td>
                            <input type="text" id="caja-usuario" name="caja-usuario" autocomplete="off" class="form-control" style="width: 200px; height: 30px;" disabled>
                        </td>
                    </tr>

                    <tr>
                        <td  align="right" width='45%' height='50px' >
                            Password :
                        </td>
                        <td>
                            <input type="password" id="caja-password" name="caja-password" autocomplete="off" class="form-control" style="width: 200px; height: 30px;" required>
                        </td>
                    </tr>

                    <tr bgcolor="#6C84E8">
                        <td width='45%' height='50px' align="center" colspan="2">
                            <input type="submit" name="registrar" id="registrar" class="btn btn-danger" value="Registrar">
                            <input type="button" name="cancelar" class="btn btn-danger" value="Cancelar" onclick="location.href = '../vistas/form_menu.php' ">
                        </td>
                    </tr>

                </table>
            </form>       
        </div>

        <div>
            <br>
        </div>

        <div>
            <table border="1" align="center" width="60%" bgcolor='#85F5DB'>
                <tr align="center" height="25px" bgcolor="#3799A9">
                    <td>
                        DNI
                    </td>
                    <td>
                        Nombre(s)
                    </td>
                    <td>
                        Apellidos
                    </td>
                    <td>
                        Usuario
                    </td>
                    <td>
                        Perfil
                    </td>
                    <td>
                        Estado
                    </td>
                    <td>
                        Operacion
                    </td>
                </tr>

                <?php
                    //incluimos la conexion a BD
                    require_once("../modelos/config.php");
                    $conexion = conectarBD();

                    //consulta para cargar los datos
                    $sqlListarClientes = "SELECT c.cod_cliente, c.dni_cliente, c.nombre_cliente, c.apellidos_cliente, u.dni_user, u.perfil, c.estado_cliente  "
                            . "FROM clientes c, usuarios u "
                            . "WHERE c.cod_cliente=u.cod_cliente";

                    $resultado = $conexion->query($sqlListarClientes);
                ?>

                <?php
                    while ($col = $resultado->fetch_object()) {
                ?>
                    <tr align="center" height="25px">
                        <td>
                            <?php echo $col->dni_cliente ?>
                        </td>
                        <td>
                            <?php echo $col->nombre_cliente ?>
                        </td>
                        <td>
                            <?php echo $col->apellidos_cliente ?>
                        </td>
                        <td>
                            <?php echo $col->dni_user ?>
                        </td>
                        <td>
                            <?php echo $col->perfil ?>
                        </td>
                        <td>
                            <?php
                                $estado = $col->estado_cliente;
                                if ($estado==1) {
                                    echo 'Activo';
                                }else{
                                    echo 'Inactivo';
                                }  
                            ?>
                        </td>
                        <td>
                            <a href="../modelos/gestionar_cliente.php?id=<?php echo $col->cod_cliente ?>&accion=darBaja">
                                <image src="../imagenes/iconos/darbaja.png" width="30px" height="25px"/>
                            </a>
                            <a href="../vistas/form_modificarcliente.php?id=<?php echo $col->cod_cliente ?>">
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