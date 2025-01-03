<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Adeudos</title>
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
			require_once('../usuario_global/Conexion.php');
			$base = new Conexion();
			$conn = $base->getConn();
			
			session_start();
			if(isset($_SESSION["TYPE"]) && $_SESSION["TYPE"] == 2){
				$TYPE = $_SESSION["TYPE"];
			}else{
				echo "No has iniciado sesión";
				header("Location: ../usuario_global/index.php");
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
							<h1>Tienes estas deudas </h1>
							
						</header>
					</section>
					<?php
					
					?>
					
					
					
					
					
					
					
					
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