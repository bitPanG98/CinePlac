<!DOCTYPE html>

<?php

		session_start();
		$connect = mysqli_connect("localhost", "root", "", "bd_cineplac");

		/*--------------------------------------------ACCION DE AGREGAR ITEM A SESSION-----------------------------------------------------------------------------------------*/
				if(isset($_POST["add_carrito"])){

					/*Verificar si el stock disponible*/
					$stockPelicula=0;
					$codPelicula = $_GET["id"]; 
					$cantidadAdd = $_POST["caja_cantidad"];

					$sql_GetStockPelicula = "SELECT stock FROM peliculas WHERE cod_pelicula='$codPelicula' ";
					$getStockPeli = mysqli_query($connect, $sql_GetStockPelicula); 

				     while ($row = $getStockPeli->fetch_array(MYSQLI_ASSOC)) {
				            $stockPelicula = $row['stock'];
				     }

				    if ($stockPelicula < $cantidadAdd) {
				    	echo '<script>alert("La cantidad , supera el stock disponible de la pelicula")</script>';
				    }else{

				    	if(isset($_SESSION["carrito_alquiler"])){
					
							$item_array_id = array_column($_SESSION["carrito_alquiler"], "item_id");
							if(!in_array($_GET["id"], $item_array_id)){
									
									$count = count($_SESSION["carrito_alquiler"]);
									$item_array = array(
									'item_id' => $_GET["id"],
									'item_name' => $_POST["hidden_nombre"],
									'item_price' => $_POST["hidden_precio"],
									'item_quantity' => $_POST["caja_cantidad"]
									);
									$_SESSION["carrito_alquiler"][$count] = $item_array ;
						
							}else{

									echo '<script>alert("El producto ya se encuentra agregado")</script>';
							}
					
						}else{
							$item_array = array(
							'item_id' => $_GET["id"],
							'item_name' => $_POST["hidden_nombre"],
							'item_price' => $_POST["hidden_precio"],
							'item_quantity' => $_POST["caja_cantidad"]
							);
							$_SESSION["carrito_alquiler"][0] = $item_array;
						}

				    }


		}

		/*-------------------------------------------------ACCION DE QUITAR ITEM EN SESSION--------------------------------------------------------------------------------*/
		if(isset($_GET["action"])){

				if($_GET["action"] == "delete"){

					foreach($_SESSION["carrito_alquiler"] as $keys => $values){
					
						if($values["item_id"] == $_GET["id"]){
								unset($_SESSION["carrito_alquiler"][$keys]);
								//echo '<script>alert("Producto eliminado")</script>';
								echo '<script>window.location="form_alquilar.php"</script>';
						}

					}		

				}

		}
		/*---------------------------------------------------------------------------------------------------------------------------------------*/

?>


<html>
<head>
	<title> Alquiler de Peliculas </title>
	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="../css/alquiler/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css">

	<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>

				<script type="text/javascript">
				function datosTrab(tribunal){
					alert("Codigo de combo -> ");
					//document.location.href='http://127.0.0.1/dinamica.php?valor='+tribunal;
				}
			</script>

</head>

<body>

<?php


?>

	<table  border="0" width="50%" align="center" >
			<tr>
				<td align="center">
						<div align="justify" class="modal" id=""  style="margin: 0 0 0 0;top: 0;left: 0px; position: relative; width: 100%; height: 10%; font-family: Times New Roman;">
                                                
		   						<div class="modal-header">
		            					<h3 id="" style="text-align: center"> Peliculas de Alquiler </h3>
		            					<br>

		            					<!---------------------------CARGAR GENEROS EN COMBOBOX------------------------------------------------------------------------------>
		            					Genero : 
		            					<select name="combo_genero" style="font-family: Times New Roman;" onchange ="datosTrab(this.value);">
		            						<?php
					                                //incluimos la conexion a BD
					                                require_once("../modelos/config.php");
					                                $conexion = conectarBD();

					                                //consulta para cargar los datos
					                                $sqlListarGeneros = "SELECT  cod_generopelicula, nombre_gp "
					                                        . "FROM generos_peliculas  "
					                                        . "WHERE estado=1 ";

					                                $result = $conexion->query($sqlListarGeneros);

					                                while ($col = $result->fetch_object()) {
					                            ?>
					                                <option value='<?php echo $col1->cod_generopelicula; ?>'>
					                                    <?php 
					                                         echo $col->nombre_gp;
					                                    ?>
					                                </option>  
				                            <?php
				                                }
				                            ?>  
		            					</select> <br>

										<!--------------------------------------------CAJA INPUT PARA BUSCAR------------------------------------------------------------------>
		            					Buscar : <input type="text" name="caja_buscar" id="caja_buscar" placeholder="Buscar" style="font-family: Times New Roman;">
		    					</div>
		    
		    					<div class="modal-body" style="max-height:320px;">
		        					<table id="tabla_peliculas" width="100%" border="0" cellspacing="0" cellpadding="0" class="data-tbl-simple table table-bordered user-tbl">
											
										<!--------------------------------------------------------------------CARGAR PELICULAS ------------------------------------------------------------------------------------->
												<?php
					
													$query = "SELECT * FROM peliculas ORDER BY cod_pelicula ASC";
													$result = mysqli_query($connect, $query);
													if(mysqli_num_rows($result) > 0){

														while($row = mysqli_fetch_array($result)){

												?>
												<tbody>
													<tr >
														<form name="form_alquilar" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?action=add&id=<?php echo $row["cod_pelicula"]; ?>" enctype="multipart/form-data">

															<td width="30%" style="text-align: center; border: 0px; line-height: 15px;">
																<?php
										                             echo "<img WIDTH='120px' HEIGHT='160px' src='data:imagen/jpeg;base64,".base64_encode($row["imagen"]). "'  class='img-responsive' />";
										                        ?>
															</td>
															
															<td style="vertical-align: middle;" >
																<label id="search_nombre"> [+] Nombre : <?php echo $row["nombre"]; ?></label>
								                                <label> [+] Precio U : <?php echo $row["precio"]; ?> $</label>
								                                <label> [+] Stock : <?php echo $row["stock"]; ?> </label>
															</td>

															<td style="text-align: center; vertical-align: middle;" >
																<label >Cantidad : </label>
																<input type="number" name="caja_cantidad" id="caja_cantidad" value="1" min="1" max="50"  maxlength="2" style="width: 50px; font-family: Times New Roman; text-align: center;" ><br>
																<input type="submit" name="add_carrito" id="add_carrito" value="Agregar" class="btn btn-danger" style="font-family: Times New Roman; ">
														
																<input type="hidden" name="hidden_nombre" value="<?php echo $row["nombre"]; ?>" />
																<input type="hidden" name="hidden_precio" value="<?php echo $row["precio"]; ?>" />
															</td>
															
														</form>
													</tr>    
												</tbody>

												<?php
														}
													}
												?>

										<!--------------------------------------------------------------------------------------------------------------------------------------------------------->

		        					</table>
		     					</div>

		     					<div class="modal-footer"  id="" style="padding: 0 0 0 0; text-align: center; ">
		     						Las mejores peliculas :) 
		     					</div>

						</div>
				</td>

			</tr>
			 
	</table>

		<!-----------------------ESPACIO----------------------------------------->
	<div style="clear:both">
			<br>
	</div>


<!----------------------------------IR AGREGANDO DINAMICAMENTE LOS DETALLES D ELAS PELICULAS A ALQUILAR-------------------------------------------------------------------->

			<div class="table-responsive">
				<table id="" class="table table-bordered" align="center" style="width: 50%; font-family: Times New Roman; font-size: 14px;">

						<tr>
							<td colspan="5" align="left" bgcolor="#69E4AC" class="hover">
								<h3>Detalle de Alquiler</h3>
							</td>
						</tr>

						<tr>
							<th width="40%" style="text-align: center;">
								Descripción
							</th>
							
							<th width="10%" style="text-align: center;">
								Cantidad
							</th>
						
							<th width="20%"  style="text-align: center;">
								Precio
							</th>
							
							<th width="15%" style="text-align: center;">
								Sub Total
							</th>

							<th width="5%">
								
							</th>
						</tr>

						<?php
							if(!empty($_SESSION["carrito_alquiler"])){
								
								$total = 0;
								foreach($_SESSION["carrito_alquiler"] as $keys => $values){
						?>
							
						<tr>
								<td>
									<?php echo $values["item_name"]; ?>		
								</td>

								<td style="text-align: right;">
									<?php echo $values["item_quantity"]; ?>		
								</td>

								<td style="text-align: right;">
									<?php echo $values["item_price"]; ?>$
								</td>

								<td style="text-align: right;">
									<?php echo number_format($values["item_quantity"] * $values["item_price"], 2);  ?> $
								</td>
								
								<td>
									<a href="form_alquilar.php?action=delete&id=<?php echo $values["item_id"]; ?>" class="btn btn-primary"><span class="text-danger">Quitar</span></a>
								</td>
						</tr>
						
						<?php
									$total = $total + ($values["item_quantity"] * $values["item_price"]);
								}
						?>

						<tr>
							<td colspan="3" style="text-align: right;">
								Total
							</td>

							<td style="text-align: right;">
								<?php echo number_format($total, 2); ?> $
							</td>

							<td>
								
							</td>
						</tr>
					<?php
							}
					?>
				</table>
			</div>
			<!----------------------------------------------------------------------TABLA PARA BOTONES---------------------------------------------------------------------------------------->
			<div>
				<table align="center" width="50%">
					<tr>
						<td align="center" height="50px">

							<a href="../modelos/gestionar_alquiler.php?action=registrar" class="btn btn-danger">
                                <image src="../imagenes/iconos/modificar.png" width="50px" height="25px"/>
                            </a>

							<input type="button" name="cancelar" value="Cancelar" class="btn btn-danger" style="font-family: Times New Roman; font-size: 14px; width: 100px;" onclick="location.href = '../vistas/form_menu.php'">
						</td>
					</tr>
				</table>
			</div>

			<!------------------------------FILES JS ---------------------------------->

			<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>

			<!---------------------------------------------SCRIPT  PARA CONSULTAR DINAMICAMENTE------------------------------------------------------------------------>
			<script>
				 // Write on keyup event of keyword input element
				 $(document).ready(function(){
					 $("#caja_buscar").keyup(function(){
						 _this = this;
						 // Show only matching TR, hide rest of them
						 $.each($("#tabla_peliculas  tbody tr "), function() {
							 if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
							 $(this).hide();
							 else
							 $(this).show();
						 });
					 });
				});
			</script>
			<!--------------------------------------------------------------------------------------------------------------------->


</body>
</html>