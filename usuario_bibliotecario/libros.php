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
        ?>
		
		<div id="wrapper">
		<article class= "post">
			<section>
				<h3>Busca un libro </h3>
				<form id="search" action="libros.php" method="post">
					<div class="row gtr-uniform">
						<div class="col-12"> 
								
						</div>
						<div class="col-8 col-12-xsmall">
							<input type="text" name="search" id="search" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>" placeholder="Ingresa el nombre o id del libro " />
						</div>
						<div class="col-1 col-6-xsmall">
							<button type="submit" value="" class="button icon solid fa-search" ></button>	
						</div>
						<div class="col-3 col-6-small">
						<a href="registrar_libro.php" class="button fit">Registrar libro </a>
						</div>
					</div>
				</form>
				<div class="col-9 col-12-small">
				
					<?php
					require_once('../usuario_global/Conexion.php');
					$base = new Conexion();
					$conn = $base->getConn();
					if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["search"])) {

						if ($conn->connect_error) {
							die("Error en la conexión: " . $conn->connect_error);
						}

						$search = $conn->real_escape_string($_POST["search"]);
						$sql = "CALL BuscarLibros(?)";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param("s", $search);
						$stmt->execute();
						$result = $stmt->get_result();
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '<div class="col-12">
									<div class="card">
									<div class="row gtr-uniform">
										<div class="col-7 col-12-small">
											<h3>' . htmlspecialchars($row["TITULO"]) . '</h3>
											<p>Disponibilidad: ' . htmlspecialchars($row["DISPONIBILIDAD"]) . '</p>
										</div>
										<div class="col-5 col-12-small">
											<button onclick="abrirModal(\'infoprestamos\', ' . $row["ID_DATOS_LIBRO"] . ')">Prestamos</button>
											<button onclick="abrirModal(\'ubicacion\', ' . $row["ID_DATOS_LIBRO"] . ')">Ubicacion</button>
											<button onclick="abrirModal(\'informacion\', ' . $row["ID_DATOS_LIBRO"] . ')">Información</button>
										</div>
										</div>
								</div>
								</div>
								
								';
							}
						} else {
							echo '<p>No se encontraron resultados.</p>';
						}

						$conn->close();
					}
					?>
				</div>
				<!-- Modal -->
				<div id="modal" class="modal">
					<div class="modal-content">
						<span class="close" onclick="cerrarModal()">&times;</span>
						<div id="modal-content"></div>
					</div>
				</div>
			</section>
		</article>
		
		<section id="sidebar">
				<?php
					$file_contents = file_get_contents('../footer.txt');
					echo $file_contents;
				?>
		</section>

		<script>
			function abrirModal(tipo, idLibro) {
				// Mostrar el modal
				const modal = document.getElementById('modal');
				const modalContent = document.getElementById('modal-content');
				modal.style.display = 'block';

				// Realizar una solicitud al servidor para obtener los datos del modal
				fetch(`${tipo}.php?id=${idLibro}`)
					.then(response => response.text())
					.then(data => {
						modalContent.innerHTML = data;
					})
					.catch(error => {
						modalContent.innerHTML = '<p>Error al cargar los datos.</p>';
					});
			}

			function cerrarModal() {
				document.getElementById('modal').style.display = 'none';
			}
		</script>
        <!-- Scripts -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/browser.min.js"></script>
        <script src="../assets/js/breakpoints.min.js"></script>
        <script src="../assets/js/util.js"></script>
        <script src="../assets/js/main.js"></script>
			</div>
	</body>
</html>