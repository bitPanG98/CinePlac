<?php

//Inicia una nueva sesión o reanuda la existente 
session_start();

 //Para cerrar el acceso a  todas las varibales
session_unset();

 //Eliminar todos los datos  almacenadas en la  sesión
session_destroy();

//Redirigir  a la pagina del login
require_once '../vistas/form_login.php';
//header("Loaction: ../vistas/form_login.php")

?>