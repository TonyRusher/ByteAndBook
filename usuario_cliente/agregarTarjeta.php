<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<!-- <title>Future Imperfect by HTML5 UP</title> -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<?php
		require_once('Constantes.php');
		$header = new Constantes();
		$header->getImports();
		?>
	</head>
	<body class="is-preload">
		<?PHP
			require_once('../usuario_global/Conexion.php');
			$base = new Conexion();
			$conn = $base->getConn();
			
			
			session_start();
			if(isset($_SESSION["TYPE"]) && $_SESSION["TYPE"] == 1){
				$TYPE = $_SESSION["TYPE"];
			}else{
				header("Location: ../usuario_global/index.php");
				exit();
			}
			require_once('Constantes.php');
			$header = new Constantes();
			$header->getHeader($TYPE);
			
			$numero = $_POST['numero'];
			$fecha = $_POST['fecha'];
			$cvv = $_POST['cvv'];
			if($numero != null && $fecha != null && $cvv != null){
				$stmt = $conn->prepare("CALL AgregarTarjeta(?, ?, ?, ?)");
				$stmt->bind_param("ssss", $_SESSION["ID_USUARIO"], $numero, $fecha, $cvv);
				$stmt->execute();
				$result = $stmt->get_result();
				
				echo "<script>Swal.fire({
					title: 'Tarjeta registrada',
					text: 'Se ha registrado la tarjeta correctamente',
					icon: 'success',
					confirmButtonText: 'Aceptar'
				  }).then(function() {
					window.location = 'mi_cuenta_usuario.php';
				});</script>";
				exit();
			}
			
		?>
		<!-- Wrapper -->
			<div id="wrapper">
			<?php
					session_start();
					$TYPE = $_SESSION["TYPE"];
					
					require_once('Constantes.php');
					$header = new Constantes();
					$header->getHeader($TYPE);
				?>
				<article class= "post">
				<section>
						<h3>Ingresa nueva Tarjeta!</h3>
						<form method="post" action="agregarTarjeta.php">
							<?php
											
							?>
							<div class="row gtr-uniform">

							
								<div class = "col-4 col-12-small">
									<input type="number" name="numero" id="numero" value="" placeholder="Numero de tarjeta" />
								</div>
								<div class = "col-4 col-6-small">
									<input type="date" name="fecha" id="fecha" value="" placeholder="Fecha de vencimiento" />
								</div>
								<div class = "col-4 col-6-small">
									<input type="number" name="cvv" id="cvv" value="" placeholder="CVV" />
								</div>
								
								<div class="col-12">
									<ul class="actions">
										<li><input type="submit" value="Registrar" /></li>
									</ul>
								</div>
							</div>
						</form>
					</section>
				</article>
				<section id="sidebar">
					<?php
						$file_contents = file_get_contents('footer.txt');
						echo $file_contents;
					?>
				</section>
					
			</div>

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<script src="../assets/js/breakpoints.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>
	</body>
</html>