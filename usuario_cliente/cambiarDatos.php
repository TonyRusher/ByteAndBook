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
					if(isset($_SESSION["TYPE"]) && $_SESSION["TYPE"] == 1){
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
					
					if(isset($_SESSION["TYPE"]) && $_SESSION["TYPE"] == 1){
						$idUsuario = $_SESSION["ID_USUARIO"];
						$nombre = $_SESSION["NOMBRE"];
						$apellido1 = $_SESSION["APELLIDO_1"];
						$apellido2 = $_SESSION["APELLIDO_2"];
						$telefono = $_SESSION["TELEFONO"];
						$correo = $_SESSION["CORREO"];
						$contra = $_SESSION["CONTRASENA"];
						// echo $correo;
						// echo <br>;
						// echo $contra;
						$fechaNacimiento = $_SESSION["FECHA_NACIMIENTO"];
						
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
						<h2><a >Registro de usuarios nuevos </a></h2>
					</div>
				</header>
				<section>
						<h3>Bienvenido!</h3>
						<form method="post" action="cambiarDatos.php">
							<div class="row gtr-uniform">
								<div class="col-12">
									<?php
										if (isset($_POST["Actualizar"])) {
											$newName = $_POST["nombre"];
											$newApellido1 = $_POST["apellido1"];
											$newApellido2 = $_POST["apellido2"];
											$newTelefono = $_POST["telefono"];
											$newCalle = $_POST["calle"];
											$newNumeroExt = $_POST["numeroExt"];
											$newNumeroInt = $_POST["numeroInt"];
											$newColonia = $_POST["colonia"];
											$newAlcaldia = $_POST["alcaldia"];
											$newCodigoPostal = $_POST["codigo_postal"];
											$newFechaNacimiento = $_POST["fechaNacimiento"];
											$newCorreo = $_POST["correo"];
											$newPass1 = $_POST["pass1"];
											$newPass2 = $_POST["pass2"];
											$currenPass = $_POST["currentPassword"];
											
											if (empty($newName) || empty($newApellido1) || empty($newApellido2) || empty($newCorreo) || empty($newTelefono) || empty($newCalle) || empty($newNumeroExt) || empty($newColonia) || empty($newAlcaldia) || empty($newCodigoPostal) || empty($newFechaNacimiento)) {
												echo "<script>Swal.fire('Por favor llena todos los campos ($nombre)');</script>";
											} elseif (!is_numeric( $newTelefono) || strlen($newTelefono) != 10) {
												echo "<script>Swal.fire('Por favor ingresa un número de teléfono válido');</script>";
											} elseif (!is_numeric($newNumeroExt)) {
												echo "<script>Swal.fire('Por favor ingresa un número exterior válido');</script>";
											} elseif (!is_numeric($newCodigoPostal) || strlen($newCodigoPostal) != 5) {
												echo "<script>Swal.fire('Por favor ingresa un código postal válido');</script>";
											} elseif ($pass1 != $pass2) {
												echo "<script>Swal.fire('Las contraseñas no coinciden');</script>";
											} else {
												$newNumeroInt = !empty($numeroInt) ? $numeroInt : NULL;
										
												$sql = "SELECT COUNT(*) FROM USUARIOS WHERE CORREO = ?";
												$stmt = $conn->prepare($sql);
												$stmt->bind_param("s", $newCorreo);
												$stmt->execute();
												$result = $stmt->get_result();
										
												
													
													if($result->num_rows > 0 && $newCorreo != $correo){
														echo "<script>Swal.fire('Ese correo ya está registrado {$newCorreo} = [$correo]');</script>";
													} else {
														if(empty($currenPass)){
															echo "<script>Swal.fire('Por favor ingresa tu contraseña actual');</script>";
														}else{
															if($currenPass != $contra){
																echo "<script>Swal.fire('Contraseña incorrecta ');</script>";
															}else{
																$newPass1 = !empty($newPass1) ? $newPass1 : $contra;
																$stmt = "CALL ActualizarDatosUsuario(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
																$stmt = $conn->prepare($stmt);
																$stmt->bind_param(
																	"issssssissssssi",
																	$idUsuario,
																	$newName,
																	$newApellido1,
																	$newApellido2,
																	$newTelefono,
																	$newCalle,
																	$newNumeroExt,
																	$newNumeroInt,
																	$newColonia,
																	$newAlcaldia,
																	$newCodigoPostal,
																	$newFechaNacimiento,
																	$newCorreo,
																	$newPass1,
																	$TYPE
																);
																$_SESSION["NOMBRE"] = $newName;
																$_SESSION["APELLIDO_1"] = $newApellido1;
																$_SESSION["APELLIDO_2"] = $newApellido2;
																$_SESSION["TELEFONO"] = $newTelefono;
																$_SESSION["CORREO"] = $newCorreo;
																$_SESSION["CONTRASENA"] = $newPass1;
																$_SESSION["CALLE"] = $newCalle;
																$_SESSION["NUMERO_EXT"] = $newNumeroExt;
																$_SESSION["NUMERO_INT"] = $newNumeroInt;
																$_SESSION["COLONIA"] = $newColonia;
																$_SESSION["ALCALDIA"] = $newAlcaldia;
																$_SESSION["CODIGO_POSTAL"] = $newCodigoPostal;
																$_SESSION["FECHA_NACIMIENTO"] = $newFechaNacimiento;
																$_SESSION["TYPE"] = $TYPE;
																
																
																if ($stmt->execute()) {
																	echo "<script>Swal.fire({
																		title: 'Actualización exitosa',
																		text: 'Tus datos han sido actualizados',
																		icon: 'success',
																		confirmButtonText: '<a href=\"mi_cuenta_usuario.php\">Aceptar</a>',
																											
																	});</script>";
																} else {
																	echo "<script>Swal.fire('Error: " . $stmt->error . "');</script>";
																}
															}
														}
													}
												
											}
										}
									?>
								</div>
								<div class="col-4 col-12-small">
									<label for = "nombre">Nombre</label>
									<input type="text" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" />
								</div>
								<div class="col-4 col-12-small">
									<label for = "apellido_1">Apellido paterno</label>
									<input type="text" name="apellido1" id="apellido_1" value="<?php echo $apellido1;?>" placeholder="Primer apellido" />
								</div>
								<div class="col-4 col-12-small">
									<label for = "apellido_2">Apellido materno</label>
									<input type="text" name="apellido2" id="apellido_2" value="<?php echo $apellido2;?>" placeholder="Segundo apellido" />
								</div>
								<div class="col-4 col-12-small">
									<label for = "correo">Correo</label>
									<input type="email" name="correo" id="correo" value="<?php echo $correo;?>" placeholder="correo electrónico" />
								</div>
								<div class="col-4 col-12-small">
									<label for = "pass1">Contraseña</label>
									<input type="password" name="pass1" id="pass1" value="<?php echo $pass1;?>" placeholder="Contraseña" />
								</div>
								<div class="col-4 col-12-small">
									<label for = "pass2">Confirmar contraseña</label>
									<input type="password" name="pass2" id="pass2" value="<?php echo $pass2;?>" placeholder="Confirmar contraseña" />
								</div>
								<div class = "col-4 col-12-small">
									<label for = "telefono">Teléfono</label>
									<input type="tel" name="telefono" id="telefono" value="<?php echo $telefono;?>" placeholder="Teléfono" />
								</div>
								<div class = "col-4 col-12-small">
									<label for = "fechaNacimiento">Fecha de nacimiento</label>
									<input type="date" name="fechaNacimiento" id="fechaNacimiento" value="<?php echo $fechaNacimiento;?>" placeholder="fecha de nacimiento" />
								</div>
								<div class = "col-12">
									
									<h4>Ingresa tu dirección</h4>
								</div>
							
								<div class = "col-6 col-12-small">
									<label for = "calle">Calle</label>
									<input type="text" name="calle" id="calle" value="<?php echo $calle;?>" placeholder="Calle" />
								</div>
								<div class = "col-2 col-6-small">
									<label for = "numeroExt">Número exterior</label>
									<input type="text" name="numeroExt" id="numeroExt" value="<?php echo $numeroExt;?>" placeholder="Número exterior" />
								</div>
								<div class = "col-2 col-6-small">
									<label for = "numeroInt">Número interior</label>
									<input type="text" name="numeroInt" id="numeroInt" value="<?php echo $numeroInt;?>" placeholder="Número interior" />
								</div>
								<div class = "col-2 col-6-small">
									<label for = "codigo_postal">Código postal</label>
									<input type="text" name="codigo_postal" id="codigo_postal" value="<?php echo $codigo_postal;?>" placeholder="Código postal" />
								</div>
								
								<div class = "col-6">
									<label for = "colonia">Colonia</label>
									<input type="text" name="colonia" id="colonia" value="<?php echo $colonia;?>" placeholder="colonia" />
								</div>
								
								<div class = "col-6">
									<label for = "alcaldia">Alcaldía</label>
									<input type="text" name="alcaldia" id="alcaldia" value="<?php echo $alcaldia;?>" placeholder="alcaldia" />
								</div>
								<div class = "col-6">
									<label for = "alcaldia">Contraseña actual</label>
									<input type="password" value="" name = "currentPassword" id = "currentPassword" />
								</div>
								<div class = "col-6">
									<label for = ""> _____</label>
									<input type="submit" value="Actualizar datos" name = "Actualizar" />
								</div>
								<div class="col-12">
									
										<p>Esta pagina es creada con fines académicos, tus datos serán usados unicamente de prueba</p>
								</div>
							</div>
						</form>
					</section>
				</article>
					
					
					
				</div>
				
				
					
			</div>
			
			
				
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<script src="../assets/js/breakpoints.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

	</body>
</html>