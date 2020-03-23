<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<?php  
        
        if(!isset($_SESSION)) { session_start(); }

        if (isset($_SESSION['usuario_acceso'])) {
           header("Location: ../vistas/form_menu.php");
        } 

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title> * Acceder al Sistema * </title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/personalizar/personalizar.css">
    </head>
    <body>
        <form id="form-login" name="form-login" method="post" action="../modelos/gestionar_logeo.php">
            <div class="container">
                <div class="row">

                    <div class="col-md-12">
                        <table align="center" border="0" width="30%">
                            <tr>
                                <td colspan="2" align="center" height="100px">
                                    <h3>  Inicio de Sesion :) </h3>
                                </td>
                            </tr>
                            <tr>
                                <td height="50px" align="left">
                                    Usuario : 
                                </td>
                                <td width="60%">
                                    <input type="text" id="caja_usuasrio" name="caja_usuario" class="form-control" placeholder="Usuario" aria-describedby="sizing-addon3">
                                </td>
                            </tr>

                            <tr>
                                <td height="50px" align="left">
                                    Password : 
                                </td>
                                <td width="60%">
                                    <input type="password" id="caja_password" name="caja_password" class="form-control" placeholder="Password" aria-describedby="sizing-addon3">
                                </td>
                            </tr>

                            <tr  height="50px" align="center" >
                                <td colspan="2">
                                    <input type="submit" class="btn btn-primary" name="ingresar" value="Acceder" style="width: 200px;" />
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="2" align="right" height="50px">
                                    <a href="../vistas/form_suscribirse.php">
                                        Registrarse como cliente :)
                                    </a>
                                </td>
                             </tr>
                            
                        </table>
                    </div>

                </div>
            </div>
        </form>
    </body>
</html>
