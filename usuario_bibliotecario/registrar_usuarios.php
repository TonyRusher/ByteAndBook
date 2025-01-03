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

			$nombre = $_POST["Nombre"] ?? null;
			$apellido1 = $_POST["Apellido_1"] ?? null;
			$apellido2 = $_POST["Apellido_2"] ?? null;
			$telefono = $_POST["Telefono"] ?? null;

			$calle = $_POST["calle"] ?? null;
			$numeroExt = $_POST["numeroExt"] ?? null;
			$numeroInt = $_POST["numeroInt"] ?? null;
			$colonia = $_POST["colonia"] ?? null;
			$alcaldia = $_POST["alcaldia"] ?? null;
			$codigo_postal = $_POST["codigo_postal"] ?? null;

			$fechaNacimiento = $_POST["fechaNacimiento"] ?? null;
			$correo = $_POST["correo"] ?? null;
			$pass1 = $_POST["pass1"] ?? null;
			$pass2 = $_POST["pass2"] ?? null;
		?>
		<!-- Wrapper -->
			<div id="wrapper">
				<article class= "post">
				<section>
						<h3>Registrar Usuarios</h3>
						<form method="post" action="registrar_usuarios.php">
							<div class="row gtr-uniform">
								<div class="col-12">
									<?php
										if (isset($_POST["Registrar"])) {
											if (empty($nombre) || empty($apellido1) || empty($apellido2) || empty($correo) || empty($pass1) || empty($pass2) || empty($telefono) || empty($calle) || empty($numeroExt) || empty($colonia) || empty($alcaldia) || empty($codigo_postal) || empty($fechaNacimiento)) {
												echo "<script>Swal.fire('Por favor llena todos los campos');</script>";
											} elseif (!is_numeric($telefono) || strlen($telefono) != 10) {
												echo "<script>Swal.fire('Por favor ingresa un número de teléfono válido');</script>";
											} elseif (!is_numeric($numeroExt)) {
												echo "<script>Swal.fire('Por favor ingresa un número exterior válido');</script>";
											} elseif (!is_numeric($codigo_postal) || strlen($codigo_postal) != 5) {
												echo "<script>Swal.fire('Por favor ingresa un código postal válido');</script>";
											} elseif ($pass1 != $pass2) {
												echo "<script>Swal.fire('Las contraseñas no coinciden');</script>";
											} else {
												$numeroInt = !empty($numeroInt) ? $numeroInt : NULL;
										
												$sql = "SELECT * FROM USUARIOS WHERE CORREO = ?";
												$stmt = $conn->prepare($sql);
												$stmt->bind_param("s", $correo);
												$stmt->execute();
												$result = $stmt->get_result();
										
												if ($result->num_rows > 0) {
													echo "<script>Swal.fire('Ese correo ya está registrado');</script>";
												} else {
													
													$qry = "CALL RegistrarUsuario('$nombre', '$apellido1', '$apellido2', '$telefono', '$calle', '$numeroExt', '$numeroInt', '$colonia', '$alcaldia', '$codigo_postal', '$fechaNacimiento', '$correo', '$pass1', 1 )";
													$stmt = $conn->prepare($qry);
													
													if ($stmt->execute()) {
														echo "<script>Swal.fire({
															title: 'Registro exitoso',
															text: 'Bienvenido a Aqua Expert Pro',
															icon: 'success',
															confirmButtonText: '<a href=\"index.php\">Aceptar</a>',
																								
														});</script>";
													} else {
														echo "<script>Swal.fire('Error: " . $stmt->error . "');</script>";
													}
												}
											}
										}
									?>
								</div>
								<div class="col-4 col-12-small">
									<input type="text" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" />
								</div>
								<div class="col-4 col-12-small">
									<input type="text" name="apellido1" id="apellido1" value="<?php echo $apellido1;?>" placeholder="Primer apellido" />
								</div>
								<div class="col-4 col-12-small">
									<input type="text" name="apellido2" id="apellido2" value="<?php echo $apellido2;?>" placeholder="Segundo apellido" />
								</div>
								<div class="col-4 col-12-small">
									<input type="email" name="correo" id="correo" value="<?php echo $correo;?>" placeholder="correo electrónico" />
								</div>
								<div class="col-4 col-12-small">
									<input type="password" name="pass1" id="pass1" value="<?php echo $pass1;?>" placeholder="Contraseña" />
								</div>
								<div class="col-4 col-12-small">
									<input type="password" name="pass2" id="pass2" value="<?php echo $pass2;?>" placeholder="Confirmar contraseña" />
								</div>
								<div class = "col-4 col-12-small">
									<input type="tel" name="telefono" id="telefono" value="<?php echo $telefono;?>" placeholder="Teléfono" />
								</div>
								<div class = "col-4 col-12-small">
									<input type="date" name="fechaNacimiento" id="fechaNacimiento" value="<?php echo $fechaNacimiento;?>" placeholder="fecha de nacimiento" />
								</div>
								<div class = "col-12">
									<h4>Ingresa tu dirección</h4>
								</div>
							
								<div class = "col-6 col-12-small">
									<input type="text" name="calle" id="calle" value="<?php echo $calle;?>" placeholder="Calle" />
								</div>
								<div class = "col-2 col-6-small">
									<input type="text" name="numeroExt" id="numeroExt" value="<?php echo $numeroExt;?>" placeholder="Número exterior" />
								</div>
								<div class = "col-2 col-6-small">
									<input type="text" name="numeroInt" id="numeroInt" value="<?php echo $numeroInt;?>" placeholder="Número interior" />
								</div>
								<div class = "col-2 col-6-small">
									<input type="text" name="codigo_postal" id="codigo_postal" value="<?php echo $codigo_postal;?>" placeholder="Código postal" />
								</div>
								
								<div class = "col-6">
									<input type="text" name="colonia" id="colonia" value="<?php echo $colonia;?>" placeholder="colonia" />
								</div>
								
								<div class = "col-6">
									<input type="text" name="alcaldia" id="alcaldia" value="<?php echo $alcaldia;?>" placeholder="alcaldia" />
								</div>
								<div class="col-12">
									<ul class="actions">
										<li>Esta pagina es creada con fines académicos, tus datos serán usados unicamente de prueba</li>
										<li><input type="submit" value="Registrar" name = "Registrar" /></li>
									</ul>
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