<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> * Suscribirse * </title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/personalizar/personalizar.css">
        
        <script src="../js/validacion.js"></script>
    </head>
    
    <body>
        <form id="form-suscribirse" name="form-suscribirse" method="post" action="../modelos/gestionar_suscribirse.php">
            
            <input type="hidden" name="accion" value="registrar">

            <table border="0" align="center" width="40%" bgcolor='#85F5DB'>
                <tr>
                    <td align="center" colspan="2" height="50px" bgcolor="#3799A9">
                        <h4> * Suscribirse Como Usuario * </h4>
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
                        <input type="submit" name="registrar" id="registrar" class="btn btn-danger" value="Registrar" style="width: 200px; height: 30px;" >
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" align="right" height="50px">
                        <a href="../vistas/form_login.php" >
                            Iniciar Sesion :)
                        </a>
                    </td>
                </tr>
                
            </table>
        </form>
    </body>
</html>
