<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Mi cuenta usuario</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<?php
		require_once('Constantes.php');
		$header = new Constantes();
		$header->getImports();
		?>
	</head>
	<body class="is-preload">
			
		<!-- Wrapper -->
			<div id="wrapper">
			<?php
					session_start();
					if(isset($_SESSION["TYPE"]) && $_SESSION["TYPE"] == 2){
						$TYPE = $_SESSION["TYPE"];
					}else{
						header("Location: ../usuario_global/index.php");
						exit();
					}
					require_once('Constantes.php');
					$header = new Constantes();
					$header->getHeader($TYPE);
				?>
				<div id="main">
				<?php
					require_once('../usuario_global/Conexion.php');
					$base = new Conexion();
					$conn = $base->getConn();
					
					if(isset($_SESSION["TYPE"]) && $_SESSION["TYPE"] == 2){
						$idUsuario = $_SESSION["ID_USUARIO"];
						$nombre = $_SESSION["NOMBRE"];
						$apellido1 = $_SESSION["APELLIDO_1"];
						$apellido2 = $_SESSION["APELLIDO_2"];
						$telefono = $_SESSION["TELEFONO"];
						$correo = $_SESSION["CORREO"];
						
						$calle = $_SESSION["CALLE"];
						$numeroExt = $_SESSION["NUMERO_EXT"];
						$numeroInt = $_SESSION["NUMERO_INT"];
						$colonia = $_SESSION["COLONIA"];
						$alcaldia = $_SESSION["ALCALDIA"];
						$codigo_postal = $_SESSION["CODIGO_POSTAL"];
					}else{
						echo "No has iniciado sesión";
						echo $_SESSION["TYPE"]."nada";
						header("Location: ../usuario_global/index.php");
						exit();
					}
				?>
					<article class= "post">
						<header>
							<div class="title">
								<h2><a href="#">Datos personales</a></h2>
							</div>
						</header>
						<div class = "row">
							<div class = "col-3 col-12-small">
								<h3>Nombre: </h3>
								<p></p>
							</div>
							<div class = "col-3 col-4-small">
								<p><?php echo $nombre?></p>
								<p></p>
							</div>
							<div class = "col-3 col-4-small">
								<p><?php echo $apellido1?></p>
							</div>
							<div class = "col-3 col-4-small">
								<p><?php echo $apellido2?></p>
							</div>
							<div class = "col-3 col-6-small">
								<h3>Teléfono: </h3>
							</div>
							<div class = "col-3 col-6-small">
								<p><?php echo $telefono?></p>
							</div>
							<div class = "col-3 col-6-small">
								<h3>Correo: </h3>
							</div>
							<div class = "col-3 col-6-small">
								<p><?php echo $correo?></p>
							</div>
							
							
							<div class = "col-12">
								<section>
									<hr/>
									<div class = "col-8">
										<h3>Dirección</h3>
									</div>
									<div class = "col-8">
										<p><?php echo $calle . " " . $numeroExt . " " . $numeroInt . " " . $colonia . " " . $alcaldia . " " . $codigo_postal?></p>
									</div>
								</section>
							</div>
							
						</div>
					</article>
				</div>
				
				<section id="sidebar">
				
					<?php
						$file_contents = file_get_contents('../footer.txt');
						echo $file_contents;
					?>
				</section>
					
			</div>
			
			
				
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<script src="../assets/js/breakpoints.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

	</body>
</html>