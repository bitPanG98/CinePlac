<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
        //Inicia una nueva sesión o reanuda la existente 
        session_start();
        if (isset($_SESSION['usuario_acceso'])) {
           header("Location: ../vistas/form_modificarcliente.php");
        } else {
            header("Location: ../vistas/form_login.php");
        }

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> * Modulo de Cliente * </title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/personalizar/personalizar.css">

        <script src="../js/validacion.js"></script>
    </head>
    <body>
        
        <?php

            if (isset($_GET)) {

                     //incluimos la conexion a BD
                    require_once("../modelos/config.php");
                    $conexion = conectarBD();
               
                    $codigoC = $_GET['id'];
                    $dniC="";
                    $nombreC="";
                    $apellidosC="";
                    $perfilC="";
                    $usuarioC="";
                    $estadoC="";

                    $seleccionarPerfilC="";
                    $seleccionarPerfilV="";
                    $seleccionarPerfilA="";
                    $seleccionarEstadoA="";
                    $seleccionarEstadoI="";


                    //consulta para cargar los datos
                    $sqlListarClientes = "SELECT c.dni_cliente, c.nombre_cliente, c.apellidos_cliente, c.estado_cliente,  u.dni_user, u.perfil  "
                            . "FROM clientes c, usuarios u "
                            . "WHERE c.cod_cliente=u.cod_cliente AND c.cod_cliente='$codigoC'";

                    $resultadoC = $conexion->query($sqlListarClientes);
                    
                    while ($colC = $resultadoC->fetch_object()) {
                        $dniC = $colC->dni_cliente;
                        $nombreC = $colC->nombre_cliente;
                        $apellidosC= $colC->apellidos_cliente;
                        $usuarioC = $colC->dni_user;
                        $perfilC = $colC->perfil;
                        $estadoC=$colC->estado_cliente;
                    }

                    printf($perfilC);
                    printf($estadoC);

                    if ($perfilC=="Cliente") {
                        $seleccionarPerfilC="selected";
                    }else if ($perfilC=="Vendedor") {
                        $seleccionarPerfilV="selected";
                    }else if ($perfilC=="Administrador") {
                        $seleccionarPerfilA="selected";
                    }else{
                        $seleccionarPerfilC="";
                    }

                    if ($estadoC==1) {
                        $seleccionarEstadoA="selected";
                    }else if ($estadoC==0) {
                         $seleccionarEstadoI="selected";
                    }{
                        $seleccionarEstadoA="";
                    }

            }
           

            
            if ($_POST) {


                         //incluimos la conexion a BD
                        require_once("../modelos/config.php");
                        $conexion = conectarBD();

                        $codigoCliente = $_GET['id'];
                        $dni = mysqli_escape_string($conexion, $_POST['caja-dniC']);
                        $nombre = mysqli_escape_string($conexion, $_POST['caja-nombreC']);
                        $apellidos = mysqli_escape_string($conexion, $_POST['caja-apellidosC']);
                        $password = mysqli_escape_string($conexion, md5($_POST['caja-password']));
                        $perfil = mysqli_escape_string($conexion, $_POST['perfil']);
                        $estado = mysqli_escape_string($conexion, $_POST['cbEstado']);
                        
                        if (empty($dni) || empty($nombre) || empty($apellidos) || empty($usuario) || empty($password)) {
                                    
                                        $sqlModificarCliente = "UPDATE clientes c, usuarios u "
                                        . "SET c.dni_cliente='$dni', "
                                        . "c.nombre_cliente='$nombre', "
                                        . "c.apellidos_cliente='$apellidos', "
                                        . "u.dni_user='$dni',"
                                        . "u.password_user='$password', "
                                        . "u.perfil='$perfil', "
                                        . "c.estado_cliente='$estado', "
                                        . "u.estado_user='$estado' "
                                        . "WHERE c.cod_cliente=u.cod_cliente AND c.cod_cliente='$codigoCliente'";

                                        $respuesta = mysqli_query($conexion, $sqlModificarCliente);
                                        if (!$respuesta) {
                                            printf("Error en ejecutar sentencia: %s\n", mysqli_error($conexion));
                                        } else {

                                            header('Location: ../vistas/form_clientes.php');
                                            echo "<script> alert('Datos de cliente modificados oorrecamente'); </script>";

                                        }
                                        

                        } else {

                                header('Location: ../vistas/form_modificarcliente.php');
                                echo "<script> alert('Debe completar todos los campos'); </script>";
                        }


            }


        
        ?>
        <div>    
            <form id="form-suscribirse" name="form-suscribirse" method="post" action="">

                <input type="hidden" name="accion" value="modificar">

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
                            <input type="text" id="caja-dniC" name="caja-dniC"  maxlength="8" autocomplete="off" class="form-control" value="<?php echo $dniC; ?>" style="width: 200px; height: 30px;" onkeyup="obtenerValorDNI(event);" disabled='' required="">
                            <input type="hidden" name="caja-dniC" value="<?php echo $dniC; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td align="right" width='45%' height='50px' >
                            Nombre(s) :  
                        </td>
                        <td width='55%'>
                            <input type="text" id="caja-nombreC" name="caja-nombreC" autocomplete="off" class="form-control" value="<?php echo $nombreC; ?>" style="width: 200px; height: 30px;" onkeypress="return soloLetras(event);" required>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" width='45%' height='50px' >
                            Apellidos :
                        </td>
                        <td>
                            <input type="text" id="caja-apellidosC" name="caja-apellidosC" autocomplete="off" class="form-control" value="<?php echo $apellidosC; ?>" style="width: 200px; height: 30px;" onkeypress="return soloLetras(event);" required>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" width='45%' height='50px' >
                            Perfil :
                        </td>
                        <td>
                            <select id="perfil" name="perfil">
                                <option value="Cliente"  <?php echo $seleccionarPerfilC; ?> >Cliente</option>
                                <option value="Vendedor"  <?php echo $seleccionarPerfilV; ?> >Vendedor</option>
                                <option value="Adminstrador"  <?php echo $seleccionarPerfilA; ?> >Administrador</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" width='45%' height='50px' >
                            Usuario :
                        </td>
                        <td>
                            <input type="text" id="caja-usuario" name="caja-usuario" autocomplete="off" class="form-control" value="<?php echo $usuarioC; ?>" style="width: 200px; height: 30px;" disabled>
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

                    <tr>
                        <td  align="right" width='45%' height='50px' >
                            Estado :
                        </td>
                        <td>
                            <select id="cbEstado" name="cbEstado">
                                <option value="1" <?php echo $seleccionarEstadoA;?> >
                                    Activo
                                </option>
                                <option value="0"  <?php echo $seleccionarEstadoI;?> >
                                    Inactivo
                                </option>
                            </select>
                        </td>
                    </tr>

                    <tr bgcolor="#6C84E8">
                        <td width='45%' height='50px' align="center" colspan="2">
                            <input type="submit" name="modificar" id="modificar" class="btn btn-danger" value="Modificar">
                            <input type="button" name="cancelar" class="btn btn-danger" value="Cancelar" onclick="history.back()">
                        </td>
                    </tr>

                </table>
            </form>       
        </div>
    </body>
</html>
