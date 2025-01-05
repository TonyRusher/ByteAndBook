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

        $idlibro = $_POST["Id_libro_fisico"] ?? null;
        $idusuario = $_POST["Id_usuario"] ?? null;
        $fechaDevolucion = $_POST["Fecha_Devolucion"] ?? null;
        ?>

        <!-- Scripts -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/browser.min.js"></script>
        <script src="../assets/js/breakpoints.min.js"></script>
        <script src="../assets/js/util.js"></script>
        <script src="../assets/js/main.js"></script>

	</body>
</html>