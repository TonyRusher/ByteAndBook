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
		<article class="post">
			<section>
			<h1>Buscador de Usuarios</h1>
			<div class="search-bar">
				<form method="POST" action="busqueda_usuarios.php">
			<div class="row gtr-uniform">
				<div class = "col-9 col-12-small" >
					<input type="text" name="search" placeholder="Buscar por nombre o apellido..." value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
				</div>
				<div class = "col-3 col-12-small">
					<button type="submit" class = "fit">Buscar</button>
				</div>
			</div>
				</form>
			</div>
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
					$sql = "CALL BuscarUsuarios(?)";
					$stmt = $conn->prepare($sql);
					$stmt->bind_param("s", $search);
					$stmt->execute();
					$result = $stmt->get_result();
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo '
							<div class="col-3 col-12-small">
								<div class="card">
								<div class="card-info">
									<h3>' . htmlspecialchars($row["nombre_completo"]) . '</h3>
								</div>
									<div class="col-3 col-12-small">
										<button onclick="abrirModal(\'actualizar\', ' . $row["ID_USUARIO"] . ')">Actualizar</button>
									</div>
									<div class="col-3 col-12-small">
										<button onclick="abrirModal(\'prestamos\', ' . $row["ID_USUARIO"] . ')">Préstamos</button>
									</div>
									<div class="col-3 col-12-small">
										<button onclick="abrirModal(\'adeudos\', ' . $row["ID_USUARIO"] . ')">Adeudos</button>
									</div>
									<div class="col-3 col-12-small">
										<button onclick="abrirModal(\'deudas\', ' . $row["ID_USUARIO"] . ')">Deudas</button>
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

			<script>
				function abrirModal(tipo, idUsuario) {
					// Mostrar el modal
					const modal = document.getElementById('modal');
					const modalContent = document.getElementById('modal-content');
					modal.style.display = 'block';

					// Realizar una solicitud al servidor para obtener los datos del modal
					fetch(`${tipo}.php?id=${idUsuario}`)
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
			</section>
		</article>
		<section id="sidebar">
				<?php
					$file_contents = file_get_contents('../footer.txt');
					echo $file_contents;
				?>
		</section>

        <!-- Scripts -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/browser.min.js"></script>
        <script src="../assets/js/breakpoints.min.js"></script>
        <script src="../assets/js/util.js"></script>
        <script src="../assets/js/main.js"></script>
			</div>
	</body>
</html>