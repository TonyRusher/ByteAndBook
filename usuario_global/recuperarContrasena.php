<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Recuperar contraseña</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<?php
		require_once('../usuario_cliente/Constantes.php');
		$header = new Constantes();
		$header->getImports();
		?>
	</head>
	<body class="is-preload ">

		<!-- Wrapper -->
			<div id="wrapper">

			<?php
				// use PHPMailer\PHPMailer\PHPMailer;
				// use PHPMailer\PHPMailer\Exception;
				// require 'vendor/autoload.php';

				
				
				require_once('Conexion.php');
				$base = new Conexion();
				$conn = $base->getConn();
				$userMail = $_POST['userMail'] ?? null;
				if(isset($userMail)){
					if($userMail != null){
						$stmt = $conn->prepare("CALL ObtenerContrasena(?)");
						$stmt->bind_param("s", $userMail);
						$stmt->execute();
						$result = $stmt->get_result();
						
						if ($result->num_rows > 0) {	
							while($row = $result->fetch_assoc()) {
								// $mail = new PHPMailer(true);
								
								
								$pass = $row["CONTRASENA"];
								$to = $userMail;
								$subject = "Recuperación de contraseña";
								$message = "Tu contraseña es: ".$pass;
								$headers = "From: no-reply@byteandbook.com";
								// $ans = mail($to, $subject, $message, $headers);
								
								
								// try {
								// 	// Configuración del servidor SMTP
								// 	$mail->isSMTP();
								// 	$mail->Host = 'smtp.gmail.com';
								// 	$mail->SMTPAuth = true;
								// 	$mail->Username = 'byteandbook@gmail.com';
								// 	$mail->Password = 'byteandbook123';
								// 	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
								// 	$mail->Port = 587;
								// 
								// 	// Configuración del correo
								// 	$mail->setFrom('no-reply@byteandbook.com', 'Byte and Book');
								// 	$mail->addAddress('$userMail');
								// 	$mail->Subject = 'Recuperación de contraseña';
								// 	$mail->Body = 'Tu contraseña es: $pass';
								// 
								// 	// Enviar el correo
								// 	$mail->send();
								// 	echo "Correo enviado correctamente.";
								// } catch (Exception $e) {
								// 	echo "Error al enviar el correo: {$mail->ErrorInfo}";
								// }
								// echo $ans;
							
								echo "<script>Swal.fire({
									title: 'Tu contraseña ha sido enviada a tu correo',
									icon: 'success',
									confirmButtonText: '<a href=\"index.php\">Aceptar</a>',
																		
								});</script>";
								// header("Location: index.php");
							}
						}else{
							echo "<script>Swal.fire('Correo no registrado')</script>";
						}
						// header("Location: index.php");
						// exit();
					}else{
						echo "<script>Swal.fire('Ingresa un correo')</script>";
					}
				}
								
				?>
					

				<!-- Menu -->
					

				<!-- Main -->
					<div id="main">
							<article>	
								<section>
									<div class="">
										<div class="row">
											<div class="col-8 col-12-small">
												<div class="row gtr-uniform wrap">
													<div class="col-3 col-12-small"></div>
													<div class="col-8">
														<section id="">
														<a href="#" class="logo"><img src="../images/logo.jpg" alt="" /></a>
														<header>
															<h2>Byte & Book</h2>
															<p>Tu servicio de libros favorito <a href="http://html5up.net">HTML5 UP</a></p>
														</header>
														</section>
													</div>
													<div class="col-3 col-12-small"></div>
												</div>
												
											</div>
											<div class="col-4 col-12-small ">
												<article class="post">
												<section>
													<h3>Recuperar contraseña</h3>
													<form method="post" action="recuperarContrasena.php">
														<div class="row gtr-uniform wrap">
															<div class="col-6 col-12-large">
															<input type="email" name="userMail" id="userMail" value="" placeholder="Email" />
															</div>
															<div class="col-12">
																<ul class="actions">
																	<li><input type="submit" value="Recuperar" name = "enviar"/></li>
																</ul>
																<a href="registro.php">Eres nuevo usuario? Regístrate Aquí</a>
															</div>
														</div>
													</form>													
												</article>
												</section>
											</div>
										</div>
									</div>
								</section>
							</article>
						

						<!-- Pagination -->
							

					</div>

				<!-- Sidebar -->
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