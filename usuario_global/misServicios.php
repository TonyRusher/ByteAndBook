<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Future Imperfect by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<?php
		require_once('Constantes.php');
		$header = new Constantes();
		$header->getImports();
		?>
	</head>
	<body class="is-preload">
		<?php
			require_once('Conexion.php');
			$base = new Conexion();
			$conn = $base->getConn();
			
			session_start();
			if(isset($_SESSION["TYPE"]) && $_SESSION["TYPE"] == "CLIENTE"){
				$id = $_SESSION["id"];
				$TYPE = $_SESSION["TYPE"];
			}else{
				echo "No has iniciado sesión";
				echo $_SESSION["TYPE"]."nada";
				header("Location: index.php");
				exit();
			}
		?>
		<!-- Wrapper -->
			<div id="wrapper">
			<?php
					require_once('Constantes.php');
					$header = new Constantes();
					$header->getHeader($TYPE);
				?>
				<div id="main">
					<section >
						<header>
							<h1>Próximos Servicios </h1>
							
						</header>
					</section>
					<?php
						$sql = "SELECT * FROM TODOS_SERVICIOS WHERE ID_CLIENTE = ".$id." AND ESTATUS = 0 ORDER BY FECHA_SERVICIO DESC";

						try{
							$result = mysqli_query($conn, $sql);
							if (mysqli_num_rows($result) > 0) {
								// output data of each row
								while($row = mysqli_fetch_assoc($result)) {
									$tecnico = $row["NOMBRE_TECNICO"];
									$fecha = $row["FECHA_SERVICIO"];
									$hora = $row["HORA_SERVICIO"];
									$descripcion = $row["DESCRIPCION"];
									$tipo = $row["TIPO_SERVICIO"];
									$precio = $row["PRECIO"];
									$direccion = $row["DIRECCION"];
									$telefono = $row["TELEFONO_TECNICO"];
									echo "<article class= 'post'>";
									echo "<div class = 'row '>";
									echo "<div class = 'col-4'>";
									echo "<h3>$fecha</h3>";
									echo "</div>";
									echo "<div class = 'col-4'>";
									echo "<h3>$hora</h3>";
									echo "</div>";
									echo "<div class = 'col-4'>";
									echo "<h3>$tipo</h3>";
									echo "</div>";
									echo "</div>";
									echo "<h3>Dirección</h3>";
									echo "<p>$direccion</p>";
									echo "<h3>Descripcion</h3>";
									echo "<p>$descripcion</p>";
									echo "<div class = 'row'>";
									echo "<div class = 'col-6 '>";
									echo "<h3>Plomero.</h3>";
									echo "<p>$tecnico - $telefono</p>";
									echo "</div>";
									
									echo "<div class = 'col-6  '
									<h3>Costo estimado.</h3>";
									echo "<h3>$precio</h3>";
									echo "</div>";
									echo "</div>";
									echo "</article>";
								}
							}
						}
						catch(Exception $e){
							echo "Error en la consulta".$e;
						}
						
					?>
					
					<section >
						<header>
							<h1>Servicios realizados </h1>
						</header>
					</section>
					<?php
						$sql = "SELECT * FROM TODOS_SERVICIOS WHERE ID_CLIENTE = ".$id." AND ESTATUS = 1 ORDER BY FECHA_SERVICIO DESC, HORA_SERVICIO DESC";
						
						try{
							$result = mysqli_query($conn, $sql);
							if (mysqli_num_rows($result) > 0) {
								// output data of each row
								while($row = mysqli_fetch_assoc($result)) {
									$tecnico = $row["NOMBRE_TECNICO"];
									$fecha = $row["FECHA_SERVICIO"];
									$hora = $row["HORA_SERVICIO"];
									$descripcion = $row["DESCRIPCION"];
									$observaciones = $row["OBSERVACIONES"];
									$valoracion = $row["VALORACION"];
									$comentarios = $row["COMENTARIOS"];
									$tipo = $row["TIPO_SERVICIO"];
									$precio = $row["PRECIO"];
									$direccion = $row["DIRECCION"];
									echo "<article class= 'post'>";
									echo "<div class = 'row '>";
									echo "<div class = 'col-4'>";
									echo "<h3>$fecha</h3>";
									echo "</div>";
									echo "<div class = 'col-4'>";
									echo "<h3>$hora</h3>";
									echo "</div>";
									echo "<div class = 'col-4'>";
									echo "<h3>$tipo</h3>";
									echo "</div>";
									
									
									echo "<div class = 'col-12'>";
									echo "<h3>Dirección</h3>";
									echo "<p>$direccion</p>";
									echo "</div>";
									echo "<div class = 'col-6'>";
									echo "<h3>Descripcion</h3>";
									echo "<p>$descripcion</p>";
									echo "</div>";
									echo "<div class = 'col-6'>";
									echo "<h3>Observaciones</h3>";
									echo "<p>$observaciones</p>";
									echo "</div>";
									echo "<div class = 'col-6 '>";
									echo "<h3>Plomero.</h3>";
									echo "<p>$tecnico</p>";
									echo "</div>";
									echo "<div class = 'col-6  '>";
									echo "<h3>Costo estimado.</h3>";
									echo "<h2>$ $precio</h2>";
									echo "</div>";
									echo "</div>";
									
									if($valoracion != "" || $comentarios != "" || $valoracion != null || $comentarios != null){
										echo "<h3>Valoracion del servicio</h3>";
										echo "<div class = 'row'>";
										echo "<div class = 'col-6'>";
										echo "<p>$valoracion</p>";
										echo "</div>";
										echo "<div class = 'col-6'>";
										echo "<p>$comentarios</p>";
										echo "</div>";
										echo "</div>";
										
									}	
									else{
										echo "<h3>Valorar y pagar el servicio</h3>";
										echo "<form action='valorarServicio.php' method='post'>";
										echo "<div class = 'row'>";
										echo "<div class = 'col-6'>";
										echo "<input type='radio' id='val1' name='valoracion' value='Malo'>";
										echo "<label for='val1'>Malo</label>";
										echo "<input type='radio' id='val2' name='valoracion' value='Bueno'>";
										echo "<label for='val2'>Bueno</label>";
										echo "<input type='radio' id='val3' name='valoracion' value='Excelente'>";
										echo "<label for='val3'>Excelente</label>";
										echo "</div>";
										echo "<div class = 'col-6'>";
										echo "<input type='text' name='comentario' id='comentario' value='' placeholder='Comentario' />";
										echo "</div>";
										echo "<div class = 'col-4'>";
										echo "<h5>Selecciona una tarjeta</h5>";
										echo "<select name='tarjeta'>";
										$sql = "SELECT * FROM TARJETAS WHERE ID_TARJETA IN (SELECT ID_TARJETA FROM CLIENTES_TARJETAS WHERE ID_CLIENTE = ".$id.")";
										$result = mysqli_query($conn, $sql);
										if (mysqli_num_rows($result) > 0) {
											while($row22 = mysqli_fetch_assoc($result)) {
												echo "<option value='".$row22["ID_TARJETA"]."'>".$row22["NUMERO_TARJETA"]."</option>";
											}
										}
										echo "</select>";
										echo "</div>";
										echo "<div class = 'col-6'>";
										echo "</div>";
										echo "<div class = 'col-12'>";
										echo "<input type='hidden' name='id' value='".$row["ID_SERVICIO"]."'>";
										echo "</div>";
										echo "<div class = 'col-12'>";
										echo "<ul class='actions'>";
										echo "<li><input type='submit' value='Valorar y pagar' class='primary' /></li>";
										echo "</ul>";
										echo "</div>";
										echo "</div>";
										echo "</form>";
									}

									
									echo "</article>";
									
								}
							}
						}
						catch(Exception $e){
							echo "Error en la consulta".$e;
						}
					
					
					?>
					
					
					
					
					
				</div>
				<section id="sidebar">
					<?php
						$file_contents = file_get_contents('footer.txt');
						echo $file_contents;
					?>
				</section>
				
					
			</div>
			
			
				
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>