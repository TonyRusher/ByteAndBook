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
        $fechaPrestamo = $_POST["Fecha_Prestamo"] ?? null;
        $fechaEntrega = $_POST["Fecha_Entrega"] ?? null;
        $idlibro1 = $_POST["Id_libro_fisico_1"] ?? null;
        $idusuario1 = $_POST["Id_usuario_1"] ?? null;
        $fechaDevolucion = $_POST["Fecha_Devolucion"] ?? null;
        ?>
        <!-- Wrapper -->
        <div id="wrapper">
            <article class="post">
                <section>
                    <h3>Registrar Prestamo</h3>
                    <form method="post" action="registrar_prestamo.php" id="registrar_prestamo">
                        <div class="row gtr-uniform">
                            <div class="col-12">
                                <?php
                                if (isset($_POST["Registrar"])) {
                                    if (empty($idlibro) || empty($idusuario) || empty($fechaPrestamo) || empty($fechaEntrega)) {
                                        echo "<script>Swal.fire('Por favor llena todos los campos Prestamo');</script>";
                                    } else {
                                        // Validar que la fecha de préstamo sea menor a la fecha de entrega
                                        $sql = "SELECT CASE WHEN ? < ? THEN 1 ELSE 0 END AS fecha_valida";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("ss", $fechaPrestamo, $fechaEntrega);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();

                                        if ($row["fecha_valida"] == 0) {
                                            echo "<script>Swal.fire('La fecha de préstamo debe ser anterior a la fecha de entrega');</script>";
                                        } else {
                                            $result->free();
                                            while ($conn->next_result()) {
                                                $conn->store_result();
                                            }
                                        
                                            // Llamada al segundo procedimiento
                                            $qry = "CALL ObtenerDisponibilidadLibro(?)";
                                            $stmt = $conn->prepare($qry);
                                            $stmt->bind_param("i", $idlibro);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                        
                                            if ($result->num_rows <= 0) {
                                                echo "<script>Swal.fire('El libro no está disponible');</script>";
                                            } else {
                                                $result->free();
                                                while ($conn->next_result()) {
                                                    $conn->store_result();
                                                }
                                                $qry1 = "CALL ObtenerPrestamosUsuario(?)";
                                                $stmt1 = $conn->prepare($qry1);
                                                $stmt1->bind_param("i", $idusuario);
                                                $stmt1->execute();
                                                $result1 = $stmt1->get_result();
                                                if ($result1->num_rows >= 3) {
                                                    echo "<script>Swal.fire('El usuario ya tiene 3 libros prestados');</script>";
                                                } else {
                                                    $result1->free();
                                                    while ($conn->next_result()) {
                                                        $conn->store_result();
                                                    }
                                                    $qry1 = "CALL VerificarPrestamo(?, ?)";
                                                    $stmt1 = $conn->prepare($qry1);
                                                    $stmt1->bind_param("ii", $idlibro, $idusuario);
                                                    $stmt1->execute();
                                                    $result1 = $stmt1->get_result();
                                                    if ($result1->num_rows > 0) {
                                                        echo "<script>Swal.fire('El usuario ya tiene prestado este libro');</script>";
                                                    } else {
                                                        $result1->free();
                                                        while ($conn->next_result()) {
                                                            $conn->store_result();
                                                        }
                                                        $qry1 = "CALL RegistrarPrestamo(?, ?, ?, ?, 1)";
                                                        $stmt1 = $conn->prepare($qry1);
                                                        $stmt1->bind_param("iiss", $idlibro, $idusuario, $fechaPrestamo, $fechaEntrega);

                                                        if ($stmt1->execute()) {
                                                            echo "<script>Swal.fire({
                                                                title: 'Registro exitoso',
                                                                text: 'El préstamo se ha registrado correctamente',
                                                                icon: 'success',
                                                                confirmButtonText: '<a href=\"inicio_bibliotecario.php\">Aceptar</a>',
                                                            });</script>";
                                                        } else {
                                                            echo "<script>Swal.fire('Error: " . $stmt1->error . "');</script>";
                                                        }
                                                    }
                                                }
                                            }
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
                            <div class="col-6 col-12-small">
                                <h5>Fecha Prestamo</h5>
                            </div>
                            <div class="col-6 col-12-small">
                                <h5>Fecha Entrega</h5>
                            </div>
                            <div class="col-6 col-12-small">
                                <input type="date" name="Fecha_Prestamo" id="fechaPrestamo" value="<?php echo $fechaPrestamo; ?>" placeholder="Fecha de Préstamo" />
                            </div>
                            <div class="col-6 col-12-small">
                                <input type="date" name="Fecha_Entrega" id="fechaEntrega" value="<?php echo $fechaEntrega; ?>" placeholder="Fecha de Entrega" />
                            </div>
                            <div class="col-12">
                                <input type="submit" value="Registrar" name="Registrar" />
                            </div>
                        </div>
                    </form>
                </section>
            </article>
            <article class="post">
                <section>
                    <h3>Registrar Devolucion</h3>
                    <form method="post" action="registrar_prestamo.php" id="formDevolucion">
                        <div class="row gtr-uniform">
                            <div class="col-12">
                                <?php
                                if (isset($_POST["RegistrarDevolucion"])) {
                                    if (empty($idlibro1) || empty($idusuario1) || empty($fechaDevolucion) ) {
                                        echo "<script>Swal.fire('Por favor llena todos los campos Devolucion');</script>";
                                    } else {
                                        $sql = "CALL VerificarDevolucionConPrestamo(?,?,?)";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("sss", $idlibro1, $idusuario1, $fechaDevolucion);
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
                                            $stmt->bind_param("sss", $idlibro1, $idusuario1, $fechaDevolucion);
                                            $stmt->execute();
                                            echo "<script>Swal.fire('Devolucion efectuada con éxito');</script>";
                                        } 
                                    }
                                }
                                ?>
                            </div>
                            <div class="col-6 col-12-small">
                                <input type="text" name="Id_libro_fisico_1" id="idlibro1" value="<?php echo $idlibro1; ?>" placeholder="ISBN del Libro" />
                            </div>
                            <div class="col-6 col-12-small">
                                <input type="text" name="Id_usuario_1" id="idusuario1" value="<?php echo $idusuario1; ?>" placeholder="No. Credencial Usuario" />
                            </div>
                            <div class="col-12">
                                <h4>Fecha de Devolución</h4>
                            </div>
                            <div class="col-6 col-12-small">
                                <input type="date" name="Fecha_Devolucion" id="fechaDevolucion" value="<?php echo $fechaDevolucion; ?>" placeholder="Fecha de Devolución" />
                            </div>
                            <div class="col-12">
                                <input type="submit" value="Registrar" name="RegistrarDevolucion" />
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