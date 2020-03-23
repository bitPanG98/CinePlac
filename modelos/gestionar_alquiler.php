<?php

		require_once("../modelos/config.php");
		$conexion = conectarBD();

		if (isset($_GET["action"])) {

				if($_GET["action"] == "registrar"){

						/*Iniciar session o renaudar la sesion existente*/
						session_start();

						/*Verificar si  la variable de session de carrito alquiler no esta vacia*/
						if(!empty($_SESSION["carrito_alquiler"])){

							/*Obtener codigo de Usuario logeado*/
							$codigoCliente = $_SESSION['codigoUser'];

							/*Obtener el codigo de alquiler*/
							$codigoAlquiler=0;
							$sqlGetCodigoAlquiler = mysqli_query($conexion, "SELECT * FROM alquiler");
						    $numero_rows = mysqli_num_rows($sqlGetCodigoAlquiler);
						    $codigoAlquiler = $numero_rows+1;

						    /*Obtener la fecha de alquiler*/
						    $fechaAlquiler=date("Y-m-d H:i:s");

						    /*Varibale para almacenar el total a pagar por el alquiler*/
						    $totalPagar = 0.0;

						    /*Obtener el total a pagar en el alquiler*/
						    foreach($_SESSION["carrito_alquiler"] as $keys => $values){
						    	$totalPagar += number_format($values["item_quantity"] * $values["item_price"], 2);
						    }

						    /*Variable para consultas sql para ejecutar en server BD*/
							$sqlRegistrarAlquiler="INSERT INTO alquiler VALUES('$codigoAlquiler' , '$fechaAlquiler' , '$totalPagar' ,1) ";
							/*Ejecutar la consulta sql en el  server BD*/
							$guardarA = mysqli_query($conexion, $sqlRegistrarAlquiler);
							/*Verificar si se ejecuto correctamente la consulta*/
							if ($guardarA) {
								
										/*Recorrer todos los datos d e la varibale de session*/
										foreach($_SESSION["carrito_alquiler"] as $keys => $values){

												/*Variables donde almacenar los valores del array d ela session*/
												$codPelicula = $values["item_id"];
												$cantidad = $values["item_quantity"];
												$subTotal = number_format($values["item_quantity"] * $values["item_price"], 2);
												/*Consulta a ejecutar para guardar datos en la tabla detalle alquiler */
												$sqlRegistrarDetalleAlquiler = "INSERT INTO  detalle_alquiler VALUES('$codigoAlquiler' , '$codigoCliente' , '$codPelicula' , '$cantidad' , '$subTotal')";
												/*Ejecutar la consulta*/
												$guardarDA = mysqli_query($conexion, $sqlRegistrarDetalleAlquiler);
												/*Verificar si s eejecuto la consulta*/
												if ($guardarDA) {
													
													/*Actualizamos el stock de cada peicula */
													$sqlUpdateStockPeli = "UPDATE peliculas SET stock=(stock-'$cantidad') WHERE cod_pelicula ='$codPelicula' ";
													$updateStock = mysqli_query($conexion, $sqlUpdateStockPeli);

													/*Mensaje de alerta*/
													echo'
													<script> 
														alert("Datos Guardados Satisfactoriamente :)"); 
														window.location = "../vistas/form_alquilar.php"
													</script>';
													
													/*Eliminar los datos d ela variable*/
													unset($_SESSION["carrito_alquiler"]);
													
													/*Redirgir a la pestana principal*/
													//require_once("../vistas/form_alquilar.php");
													//header("Location: ../vistas/form_alquilar.php");

												}else{

													echo'
													<script> 
														alert("Hubo un error al guardar los datos :)");
														window.location = "../vistas/form_alquilar.php"
													 </script>';

													printf("Error en ejecutar sentencia: %s\n", mysqli_error($conexion));

													/*Eliminar los datos d ela variable*/
													unset($_SESSION["carrito_alquiler"]);

												}

										}

							}else{

								echo'<script> 
									alert("Hubo un error al guardar los datos :)"); 
									window.location = "../vistas/form_alquilar.php"
								</script>';
								printf("Error en ejecutar sentencia: %s\n", mysqli_error($conexion));

							}

						}else{
							echo'
							<script> 
								alert("No se encuentran ningun detalle de alquiler a registrar"); 
								window.location = "../vistas/form_alquilar.php"
							</script>';
						}

				}
		}


?>