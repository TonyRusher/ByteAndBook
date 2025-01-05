<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Busqueda Usuarios</title>
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
		<?PHP
        require_once('../usuario_global/Conexion.php');
        $base = new Conexion();
        $conn = $base->getConn();

        $nombreusuario = $_POST["nombre_usuario"] ?? null;
        $idusuario = $_POST["Id_usuario"] ?? null;
        ?>
		<article class= "post">
			<section>
				<h3>Busqueda de Usuarios</h3>
					<form id="search" action="busqueda_usuarios.php" method="post" enctype="multipart/form-data">
						<div class="row gtr-uniform">
						<div class="col-12">
								
						</div>
						<div class="col-6 col-12-xsmall">
							<input type="text" name="Id_libro_fisico" id="Id_libro_fisico" value="" placeholder="Id libro fisico" />
						</div>
						</div>
					</form>
			</section>
						
			<section id="sidebar">
				<?php
					$file_contents = file_get_contents('../footer.txt');
					echo $file_contents;
				?>
			</section>
		</article>

        <!-- Scripts -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/browser.min.js"></script>
        <script src="../assets/js/breakpoints.min.js"></script>
        <script src="../assets/js/util.js"></script>
        <script src="../assets/js/main.js"></script>

	</body>
</html>