<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Registrar Usuarios</title>
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
        <!-- Wrapper -->
        <div id="wrapper">
            <article class="post">
                <section>
                    <h3>Registrar Prestamo</h3>
                    <form method="post" action="registrar_devolucion.php">
                        <div class="row gtr-uniform">
                            <div class="col-12">
                                <?php
                                if (isset($_POST["Registrar"])) {
                                    if (empty($idlibro) || empty($idusuario) || empty($fechaDevolucion) ) {
                                        echo "<script>Swal.fire('Por favor llena todos los campos');</script>";
                                    } else {
                                        $sql = "CALL VerificarDevolucionConPrestamo(?,?,?)";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("sss", $idlibro, $idusuario, $fechaDevolucion);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if ($result->num_rows !=0){
                                            echo "<script>Swal.fire('No puede ingresar una fecha devolucion anterior a la fecha de prestamo');</script>";
                                        }else{
                                            $result->free();
                                            while ($conn->next_result()) {
                                               $conn->store_result();
                                            }
                                            $query = "CALL ActualizarDevolucion(?,?,?)";
                                            $stmt = $conn->prepare($query);
                                            $stmt->bind_param("sss", $idlibro, $idusuario, $fechaDevolucion);
                                            $stmt->execute();
                                            echo "<script>Swal.fire('Devolucion efectuada con éxito');</script>";
                                        } 
                                    }
                                }
                                ?>
                            </div>
                            <div class="col-6 col-12-small">
                                <input type="text" name="Id_libro_fisico" id="idlibro" value="<?php echo $idlibro; ?>" placeholder="ISBN del Libro" />
                            </div>
                            <div class="col-6 col-12-small">
                                <input type="text" name="Id_usuario" id="idusuario" value="<?php echo $idusuario; ?>" placeholder="No. Credencial Usuario" />
                            </div>
                            <div class="col-12">
                                <h4>Fecha de Devolución</h4>
                            </div>
                            <div class="col-6 col-12-small">
                                <input type="date" name="Fecha_Devolucion" id="fechaDevolucion" value="<?php echo $fechaDevolucion; ?>" placeholder="Fecha de Devolución" />
                            </div>
                            <div class="col-12">
                                <input type="submit" value="Registrar" name="Registrar" />
                            </div>
                        </div>
                    </form>
                </section>
            </article>
            <section id="sidebar">
                <?php
                $file_contents = file_get_contents('../footer.txt');
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