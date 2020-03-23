<?php

function conectarBD() {

    /*$host = "sql305.260mb.net";
    $database = "n260m_22933184_bd_cineplac";
    $user = "n260m_22933184";
    $password = "Edinson1";*/

    $host = "localhost";
    $database = "bd_cineplac";
    $user = "root";
    $password = "";
    
    $link = new mysqli($host, $user, $password, $database);

    if (mysqli_connect_errno()) {
        printf("Conexión con la base de datos fallida: %s \n", mysqli_connect_error());
        exit();
    }

    return $link;
}

?>

