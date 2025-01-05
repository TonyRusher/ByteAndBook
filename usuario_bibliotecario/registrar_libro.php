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
					
					if (isset($_POST["Registrar"])) {
						$titulo = $_POST["titulo"];
						$autor = $_POST["autor"];
						$editorial = $_POST["editorial"];
						$edicion = $_POST["edicion"];
						$isbn = $_POST["isbn"];
						$idioma = $_POST["idioma"];
						$anio = $_POST["anio"];
						$resumen = $_POST["resumen"];
						$genero = $_POST["genero"];
						// 
						$imagen = $_FILES["imagen"];
						$pdf = $_FILES["pdf"];
						
						$imagen_name = $imagen["name"];
						$pdf_name = $pdf["name"];
						
						$imagen_tmp = $imagen["tmp_name"];
						$pdf_tmp = $pdf["tmp_name"];
						
						$imagen_size = $imagen["size"];
						$pdf_size = $pdf["size"];
						
						$imagen_error = $imagen["error"];
						$pdf_error = $pdf["error"];
						
						$imagen_ext = explode('.', $imagen_name);
						$imagen_actual_ext = strtolower(end($imagen_ext));
						
						$pdf_ext = explode('.', $pdf_name);
						$pdf_actual_ext = strtolower(end($pdf_ext));
						
						$allowed = array('jpg', 'jpeg', 'png');
						$allowed_pdf = array('pdf');
						
						if(in_array($imagen_actual_ext, $allowed) && in_array($pdf_actual_ext, $allowed_pdf)){
							if($imagen_error === 0 && $pdf_error === 0){
								if($imagen_size < 1000000 && $pdf_size < 1000000){
									// echo 'Imagen: '.$imagen_name;
									$imageTmpName = $_FILES['imagen']['tmp_name'];
        							$imageData = file_get_contents($imageTmpName);
									$pdfTmpName = $_FILES['pdf']['tmp_name'];
									$pdfData = file_get_contents($pdfTmpName);
									
									
									$sql = "CALL CrearLibroVirtual(?,?,?,?,?,?,?,?,?,?,?);";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param("sssssssssss", $isbn, $genero, $titulo, $editorial, $edicion, $anio, $idioma, $autor, $resumen, $pdfData, $imageData);
									if ($stmt->execute()) {
										// echo "Image uploaded and stored in database successfully!";
									} else {
										// echo "Failed to upload image to database: " . $stmt->error;
									}
									$stmt->close();
									echo "<script>Swal.fire('Libro registrado correctamente');</script>";
								}else{
									echo "<script>Swal.fire('El archivo es muy grande');</script>";
								}
							}else{
								echo "<script>Swal.fire('Hubo un error al subir el archivo');</script>";
							}
						}else{
							echo "<script>Swal.fire('No puedes subir archivos de este tipo');</script>";
						}
					}
					
					
					
				?>
					<article class= "post">
						<header>
							<div class="title">
								<h2><a href="#">Subir libro </a></h2>
							</div>
						</header>
						<form action="registrar_libro.php" method="post" enctype="multipart/form-data">
							<div class="row gtr-uniform">
								<div class="col-4 col-12-small">
									<label for="titulo">Titulo</label>
									<input type="text" name="titulo" id="titulo" value="" placeholder="Titulo" />
								</div>
								<div class="col-4 col-12-small">
									<label for="autor">Autores</label>
									<input type="text" name="autor" id="autor" value="" placeholder="Autor" />
								</div>
								<div class="col-4 col-12-small">
									<label for="editorial">Editorial</label>
									<input type="text" name="editorial" id="editorial" value="" placeholder="Editorial" />
								</div>
								<div class="col-4 col-12-small">
									<label for="edicion">Edicion</label>
									<input type="number" name="edicion" id="edicion" value="" placeholder="Edicion" />
								</div>
								
								<div class="col-4 col-12-small">
									<label for="isbn">ISBN</label>
									<input type="text" name="isbn" id="isbn" value="" placeholder="ISBN" />
								</div>
								<div class="col-4 col-12-small">
									<label for="idioma">Idioma</label>
									<input type="text" name="idioma" id="idioma" value="" placeholder="Idioma" />
								</div>
								<div class="col-4 col-12-small">
									<label for="anio">fecha de publicacion</label>
									<input type="date" name="anio" id="anio" value="" placeholder="Año de publicacion" />
								</div>
								<div class="col-4 col-12-small">
									<label for="imagen">Imagen</label>
									<input type="file" name="imagen" id="imagen" value="" placeholder="imagen" class = "button icon solid fa-upload" />
								</div>
								<div class="col-4 col-12-small">
									<label for="pdf">PDF</label>
									<input type="file" name="pdf" id="pdf" value="" placeholder="pdf" class = "button icon solid fa-upload" />
								</div>
								<div class = "col-8 col-12-small" >
									<label for="resumen">Resumen</label>
									<textarea name="resumen" id="resumen" value="" placeholder="Resumen"> </textarea>
								</div>
								<div class="col-4 col-12-small">
									<label for="genero">Genero</label>
									<?PHP
										$sql = "select * from CATALOGO_GENEROS;";
										$result = mysqli_query($conn, $sql);
										if (mysqli_num_rows($result) > 0) {
											// output data of each row
											echo "<select name='genero' id='genero'>";
											echo "<option value=''>Selecciona un género</option>";
											while($row = mysqli_fetch_assoc($result)) {
												if($row["ID_GENERO"] == $genero){
													echo "<option value='".$row["ID_GENERO"]."' selected>".$row["NOMBRE_GENERO"]."</option>";
												}else
													echo "<option value='".$row["ID_GENERO"]."'>".$row["NOMBRE_GENERO"]."</option>";
											}
											echo "</select>";
										} else {
											echo "0 results";
										}
									?>
								</div>
								<div class="col-4 col-12-small">
									<ul class="actions">
										<li><input type="submit" name="Registrar" value="Registrar" class="primary" /></li>
										<li><input type="reset" value="Limpiar" /></li>
									</ul>
								</div>
								
								
								
							</div>
						</form>
					</article>
					
					
					
				</div>
				
				<section id="sidebar">
				
					<?php
						$file_contents = file_get_contents('../footer.txt');
						echo $file_contents;
					?>
				</section>
					
			</div>
			
			<?php
				$footer = new Constantes();
				$footer->getFooter();
				$conn->close();
			?>
				
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<script src="../assets/js/breakpoints.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

	</body>
</html>