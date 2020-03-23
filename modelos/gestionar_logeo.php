<?php

function registrarAuditoria($usuario){

	require_once("../modelos/config.php");
	$conexion = conectarBD();

	$ipLogeo = "";
	$fecha_hora = date("Y-m-d H:i:s");

	$sql_RegistrarAuditoriaLogeo="INSERT INTO auditoria_login VALUES(null, '$usuario' , '$ipLogeo' , 'Accedio al sistema' , '$fecha_hora') ";
	$guardarAuditoriaLogin = mysqli_query($conexion, $sql_RegistrarAuditoriaLogeo);
	if (!$guardarAuditoriaLogin) {
		printf("Hubo un problema al registrar la auditoria de acceso");
	}

}

function accederLogin() {

    if (isset($_POST['ingresar'])) {

        require_once './config.php';
        $conexion = conectarBD();

        /* Obtener datos de inputs */
        $usuario = mysqli_real_escape_string($conexion, $_POST['caja_usuario']);
        $password = md5(mysqli_real_escape_string($conexion, $_POST['caja_password']));

        /* Condicional para verificar si los inputs, estan vacios o no */
        if (trim(empty($usuario)) or trim(empty($password))) {

            echo " "
            . "<script> "
            . "alert('Debe completar todos los datos :( ') "
            . "</script>";

            require_once '../vistas/form_login.php';
        } else {

            /* Consulta sql para obtener las credenciales de acceso */
            $sql_acceder = " SELECT cod_user, dni_user, perfil "
                    . "FROM usuarios "
                    . "WHERE estado_user=1 AND dni_user='$usuario' AND password_user='$password' ";

            /* Ejecutar la consulta */
            $resultado = $conexion->query($sql_acceder);

            /* Numero de registros obtenidos */
            $filas_obtenidas = $resultado->num_rows;

            /* Verificar si  los registros obtenidos es mayor  a cero */
            if ($filas_obtenidas > 0) {

                $fila = $resultado->fetch_assoc();
                $_SESSION['usuario_acceso'] = $fila['dni_user'];
                $_SESSION['perfil'] = $fila['perfil'];
                $_SESSION['codigoUser']=$fila['cod_user'];

                registrarAuditoria($fila['dni_user']);

                header("Location: ../vistas/form_menu.php");
                //require_once '../vistas/form_menu.php';
            } else {

                echo " "
                . "<script> "
                . "alert('Datos de acceso incorrectos :( ') "
                . "</script>";

                require_once '../vistas/form_login.php';
            }
        }
    }
}

//accederLogin();

//Inicia una nueva sesión o reanuda la existente 
session_start();
if (isset($_POST['ingresar'])) {

        if (isset($_SESSION['usuario_acceso'])) {
           header("Location: ../vistas/form_menu.php");
        } else {
            accederLogin();
        }

}

?>

