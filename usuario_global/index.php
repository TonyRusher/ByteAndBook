<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Byte & Book</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<?php
		require_once('../usuario_cliente/Constantes.php');
		$header = new Constantes();
		$header->getImports();
		?>
		
	</head>
	<body class="is-preload ">

	<?php
		require_once 'Conexion.php';
		require_once 'Clases.php';
		$base = new Conexion();
		$conn = $base->getConn();
		
		session_start();
		if(isset($_SESSION["TYPE"]) && $_SESSION["TYPE"] == 1){
			header("Location: ../usuario_cliente/inicio_usuario.php");
			exit();
		}else if(isset($_SESSION["TYPE"]) && $_SESSION["TYPE"] == 2){
			header("Location: ../usuario_bibliotecario/inicio_bibliotecario.php");
			exit();
		}else if(isset($_SESSION["TYPE"]) && $_SESSION["TYPE"] == 3){
			header("Location: ../usuario_admin/inicio_administrador.php");
			exit();
		}
		
		$userMail = $_POST['userMail'] ?? null;
		$userPassword = $_POST['userPassword'] ?? null; 
		if($userMail != "" && $userPassword != ""){
			// echo "Datos recibidos\n";
			// echo $userMail.'\n';
			// echo $userPassword.'\n';
			try{
				// 	$stmt = $conn->prepare("CALL ObtenerContrasena(?)");
				// 	$stmt->bind_param("s", $userMail);
				// 	$stmt->execute();
				// 	$result = $stmt->get_result();
					
				$stmt = $conn->prepare("CALL ObtenerDatosUsuario(?, ?)");
				$stmt->bind_param("ss", $userMail, $userPassword);
				$stmt->execute();
				$result = $stmt->get_result();
				// echo "Consulta realizada\n";
			}catch(Exception $e){
				// echo "Error en la consulta".$e;
			}
			
			if ($result->num_rows == 1) {

				echo "Datos encontrados";
				$row = $result->fetch_assoc();
				
				$idUsuario = $row["ID_USUARIO"];
				$nombre = $row["NOMBRE"];
				$apellido1 = $row["APELLIDO_1"];
				$apellido2 = $row["APELLIDO_2"];
				$telefono = $row["TELEFONO"];
				$tipo = $row["TIPO_USUARIO"];
				$userMail = $row["CORREO"];
				$userPassword = $row["CONTRASENA"];
				$calle = $row["CALLE"];
				$numeroExt = $row["NUMERO_EXT"];
				$numeroInt = $row["NUMERO_INT"];
				$colonia = $row["COLONIA"];
				$alcaldia = $row["ALCALDIA"];
				$codigoPostal = $row["CODIGO_POSTAL"];
				echo "Datos obtenidos";
				
				
				// echo "Objetos creados";
				$_SESSION["ID_USUARIO"] = $idUsuario;
				$_SESSION["NOMBRE"] = $nombre;
				$_SESSION["APELLIDO_1"] = $apellido1;
				$_SESSION["APELLIDO_2"] = $apellido2;
				$_SESSION["TELEFONO"] = $telefono;
				$_SESSION["CORREO"] = $userMail;
				$_SESSION["CONTRASENA"] = $userPassword;
				
				$_SESSION["CALLE"] = $calle;
				$_SESSION["NUMERO_EXT"] = $numeroExt;
				$_SESSION["NUMERO_INT"] = $numeroInt;
				$_SESSION["COLONIA"] = $colonia;
				$_SESSION["ALCALDIA"] = $alcaldia;
				$_SESSION["CODIGO_POSTAL"] = $codigoPostal;
				
				$_SESSION["TYPE"] = $tipo;
				
				echo "<script>Swal.fire({
					icon: 'success',
					title: 'Bienvenido $nombre',
					
					})
				</script>";
				
				if($tipo == 1){
					header("Location: ../usuario_cliente/inicio_usuario.php");
					exit();
				}else if($tipo == 2){
					header("Location: ../usuario_bibliotecario/inicio_bibliotecario.php");
					exit();
				}else if($tipo == 3){
					header("Location: ../usuario_administrador/inicio_administrador.php");
					exit();
				}
			} else {
				echo "0 results";
				echo "<script>Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Usuario o contraseña incorrectos!',
					// footer: '<a href>Why do I have this issue?</a>'
					})
				</script>";
			}
				
		}
			
			
				

		
		
		?>
		
		
		<div id="wrapper">
				<div id="main">
						<article>	
							<section>
								<div class="">
									<div class="row">
										<div class="col-8 col-12-small">
											<div class = "row gtr-uniform wrap">
												<div class="col-3 col-2-small"></div>
												<div class="col-8">
												<a href="#" class=""><img src="../images/logo.jpg" alt="logo de la compañia" /></a>
													
													<h1>Bienvenido a Byte & Book</h1>
													<p>Tu servicio de libros favorito</a></p>

												</div>
												<div class="col-1 col-2-small"></div>
											</div>
										</div>
										<div class="col-4 col-12-small ">
											<article class = "post">
											<section>
												<h3>Inicia Sesion</h3>
												<form method="post" action="index.php">
													<div class="row gtr-uniform wrap">
														<div class="col-6 col-12-large">
														<input type="email" name="userMail" id="userMail" value="" placeholder="Email" />
														</div>
														<div class="col-6 col-12-large">
															<input type="password" name="userPassword" id="userPassword" value="" placeholder="Contraseña" />
															<a href="recuperarContrasena.php">Recuperar contrasena</a>
														</div>
														
														<div class="col-12">
															<ul class="actions">
																<li><input type="submit" value="Acceder" /></li>
																<li><input type="reset" value="Borrar" /></li>
															</ul>
															<a href="registro.php">Eres nuevo usuario? Regístrate Aquí</a>
														
														</div>
													</div>
												</form>
											</section>
											</article>
										</div>
									</div>
								</div>
							</section>
						</article>
					

					<!-- Pagination -->
						

				</div>

			<!-- Sidebar -->
				
		</div>

		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>

	</body>
</html>