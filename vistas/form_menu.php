<!DOCTYPE html>
<html>
    <head>
        <title> * MENU PRINCIPAL * </title>

        <link rel="stylesheet" href="../css/bootstrap.min.css" />    
        <link rel="stylesheet" type="text/css" href="../css/personalizar/personalizar.css">

    </head>

<?php

session_start();
if (isset($_SESSION['usuario_acceso'])) {

    $usuario = $_SESSION['usuario_acceso'];
    $perfil = $_SESSION['perfil'];

    $modulos_user="";
    
    if ($perfil == "Administrador") {
        
        $modulos_user = "  
                        <tr>	

                            <td align='center' height='30px'>
                                <h4>
                                    <a href='../vistas/form_clientes.php' title='Modulo Clientes' >
                                            <img src='../imagenes/cliente.png' width='48' height='48' border='0' > <br>
                                            Modulo Clientes 
                                    </a>
                                </h4>
                            </td>

                            <td align='center' height='30px'>
                                <h4>
                                    <a href='../vistas/form_alquilar.php' title='Modulo de Alquiler'>
                                            <img src='../imagenes/reservacion.png' width='48' height='48' border='0'><br>
                                            Modulo <br> Alquiler de Peliculas
                                    </a>
                                </h4>		
                            </td>

                            <td align='center' height='30px'>
                                <h4>
                                    <a href='../vistas/form_peliculas.php' title='Modulo Peliculas' >
                                            <img src='../imagenes/pelicula.png' width='48' height='48' border='0' > <br>
                                            Modulo Peliculas
                                    </a>
                                </h4>
                            </td>
                            
                        </tr>
                        
                        <tr>
                            <td align='center' height='30px'>
                                <h4>
                                    <a href='../vistas/form_generos.php' title='Modulo Peliculas' >
                                            <img src='../imagenes/generopeli.png' width='48' height='48' border='0' > <br>
                                            Generos Peliculas
                                    </a>
                                </h4>
                            </td>
                        </tr>
                        ";
        
    } elseif ($perfil == "Cliente") {

        $modulos_user = "  
                        <tr>	
                            <td align='center' height='30px'>
                                <h4>
                                    <a href='../vistas/form_alquilar.php' title='Modulo de Alquiler'>
                                            <img src='../imagenes/reservacion.png' width='48' height='48' border='0'><br>
                                            Modulo <br> Alquiler de Peliculas
                                    </a>
                                </h4>		
                            </td>
                        </tr>
                        ";
    
        
    } else {

        $modulos_user = "  
                        <tr>	
                            <td align='center' height='30px'>
                                <h4>
                                    PERFIL DE USUARIO NO IDENTIFICADO, MODULOS NO DISPONIBLE
                                </h4>		
                            </td>
                        </tr>
                ";
    }
    
} else {
    header('Location: ./form_login.php');
}

?>
   
<body bgcolor="#FFFFFF">        
    <div>
        <table bgcolor='#A7E288' border='0' style='border-collapse: collapse;'' width='100%'' align='center' bgcolor='#83B8E8'>
            <tr>
                <td colspan="3" height="50px">
                    <h1> 
                        * CINE PLAC * 
                        <img src='../imagenes/cineplac3.png'  width='75' height='48' border='0'>
                    </h1>
                </td>
            </tr>

            <tr>
                <td width='25%'>

                </td>

                <td width='50%' bgcolor='#A7E288' align="left" height="100px">
                        &nbsp; Usuario : <?php echo "<p style='font-color:#A7E288'>".$usuario."</p>"; ?>  <br>
                        &nbsp; Perfil  : <?php echo $perfil; ?> <br>
                        <a href='../modelos/logout.php'>
                            <img src="../imagenes/salir.png">
                           &nbsp; Cerrar     
                        </a>   
                </td>

                <td width='25%'>
                    
                </td>

            </tr>
        </table>
    </div>

    <div>
        <table bgcolor='#83B8E8' border='3' style='border-collapse: collapse;' width='50%' align='center' bgcolor='#83B8E8'>
            <tr>
                <td colspan='4' height='50px'  align='center' bgcolor='#83B8E8'>
                    <h1>MENU PRINCIPAL<h1>
                </td>
            </tr>

            <tr>
                <?php 
                    echo "".$modulos_user;
                ?>
            </tr>
        </table>
    </div>
    
</body>
</html>

