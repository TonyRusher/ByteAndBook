<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Prestamos</title>
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
			if(isset($_SESSION["TYPE"]) && $_SESSION["TYPE"] == 1){
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
					<article class="post">
						<header>
							<div class="title">
								<h2>Prestamos</h2>
							</div>
						</header>
						<section>
						
						<div class="table-wrapper">
							<table>
								<thead>
									<tr>
										<th>Libro</th>
										<th>Fecha prestamo</th>
										<th>Fecha devolución</th>
										<th>Estado</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sql = "CALL getPrestamos($_SESSION[ID_USUARIO])";

										$result = $conn->query($sql);
									
										if ($result->num_rows > 0) {
											

											$row = $result->fetch_assoc();
											
											
											$estado =  $row['ESTADO'];
											$estadoTXT = "";
											if($estado == 1){
												$estadoTXT = "Prestado";
											}else if($estado == 2){
												$estadoTXT = "No devuelto";
											}else if($estado == 3){
												$estadoTXT = "Adeudo";
											}else {
												$estadoTXT = "Devuelto";
											}
											
											
											
											while ($row) {
												echo "<tr>";
												echo "<td>" . htmlspecialchars($row['TITULO']) . "</td>";
												echo "<td>" . $row['FECHA_PRESTAMO'] . "</td>";
												echo "<td>" . $row['FECHA_ENTREGA'] . "</td>";
												echo "<td>" . $estadoTXT . "</td>";
												echo "</tr>";
												$row = $result->fetch_assoc();
											}
											
										} else {
											// echo "<p>No hay libros en préstamo.</p>";
										}
									?>
									
								</tbody>
								
							</table>
						</div>
						</section>
					</article>
		
					
					
					
					
					
					
					
					
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