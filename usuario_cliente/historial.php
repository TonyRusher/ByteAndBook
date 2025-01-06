<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Historial</title>
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
								<h2><a href="#">Has leido estos libros </a></h2>
							</div>
							<!-- <div class="meta">
								<h2 href="cambiarDatos.php" class="icon solid fa-pen"><span class="label">Twitter</span></h2>
								<a class="published" href="cambiarDatos.php">Editar información</a>
							</div> -->
						</header>
						<div class="slider-container">
							<div class="slider">
								<?php 
									$stmt = "CALL ObtenerLibrosValorados(?);";
									$query = $conn->prepare($stmt);
									$query->bind_param("i", $idUsuario);
									$query->execute();
									$result = $query->get_result();
									if($result->num_rows > 0){
										while($row = $result->fetch_assoc()){
											$titulo = $row['TITULO'];
											$autores = $row['AUTORES'];
											$valoracion = $row['VALORACION'];
											$comentario = $row['COMENTARIO'];
											$idValoracion = $row['ID_VALORACION'];
											$idLibroVirtual = $row['ID_LIBRO_VIRTUAL'];
											
											echo "<article class='mini-post' data-title='$titulo' data-author='$autores' 
											data-valoracino = '$valoracion' data-comentario = '$comentario' data-id-valoracion = '$idValoracion' data-id-libro-virtual = '$idLibroVirtual'>
												<header>
													<h3><a href='#'>$titulo</a></h3>
													<time class='published' datetime='2015-10-20'>$autores</time>
													<img src='../usuario_global/imagen.php?id=$idLibroVirtual' alt='' />
												</header>
											</article>";
										}
									}
								
								?>
								
							</div>
						</div>
									
					</article>
				</div>
				
				<section id="sidebar">
				
					<?php
						$file_contents = file_get_contents('../footer.txt');
						echo $file_contents;
					?>
				</section>
					
			</div>
			
			<div id="modal" class="modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<h2 id="modal-title">Book Title</h2>
					<p><strong>Author:</strong> <span id="modal-author">Author Name</span></p>
					
					<button id="read-more-btn">Read More</button>
					
					<img id="modal-image" src="https://via.placeholder.com/400x300" alt="Book Image" />
				</div>
			</div>
			<script>
								// Get the slider and the buttons
				const slider = document.querySelector('.slider');
				const prevBtn = document.createElement('div');
				const nextBtn = document.createElement('div');
				

				// Create buttons for navigation
				prevBtn.classList.add('prev');
				nextBtn.classList.add('next');
				prevBtn.innerText = '←';
				nextBtn.innerText = '→';

				// Append buttons to the container
				const container = document.querySelector('.slider-container');
				container.appendChild(prevBtn);
				container.appendChild(nextBtn);

				// Set initial index for the slider
				let index = 0;

				// Function to move to the next slide
				nextBtn.addEventListener('click', () => {
					if (index < slider.children.length - 1) {
						index++;
						slider.style.transform = `translateX(-${index * 320}px)`; // Move left
					}
				});

				// Function to move to the previous slide
				prevBtn.addEventListener('click', () => {
					if (index > 0) {
						index--;
						slider.style.transform = `translateX(-${index * 320}px)`; // Move right
					}
				});
				
				
				const modal = document.getElementById("modal");
				const closeButton = document.querySelector(".close");
				const readMoreBtn = document.getElementById("read-more-btn");
				// const modalDescriptionSummary = document.getElementById("modal-description-summary");
				// const modalFullDescription = document.getElementById("modal-full-description");
				const modalImage = document.getElementById("modal-image");

				// Open modal when a mini-post is clicked
				const miniPosts = document.querySelectorAll('.mini-post');
				miniPosts.forEach(post => {
					post.addEventListener('click', () => {
						const title = post.getAttribute('data-title');
						const author = post.getAttribute('data-author');
						// const published = post.getAttribute('data-published');
						// const description = post.getAttribute('data-description');
						// const genero = post.getAttribute('data-genero');
						const imageSrc = post.querySelector('img').src; // Get the image source
						link = post.getAttribute('data-link');
						// Set modal content
						document.getElementById("modal-title").innerText = title;
						document.getElementById("modal-author").innerText = author;
						// document.getElementById("modal-published").innerText = published;
						// document.getElementById("modal-genero").innerText = genero;
						

						// Show only the summary initially
						// const summary = description.substring(0, 150) + '...'; // Summary of first 150 characters
						// modalDescriptionSummary.innerText = summary;
						// modalFullDescription.innerText = description; // Full description

						// Set the image for the modal
						modalImage.src = imageSrc;

						// Show modal
						modal.style.display = "block";
						document.body.style.overflow = "hidden"; // Lock the body scroll
					});
				});

				// Close modal when clicking on the close button
				closeButton.addEventListener('click', () => {
					modal.style.display = "none";
					document.body.style.overflow = "auto"; // Unlock the body scroll
				});

				// Close modal if the user clicks outside of the modal content
				window.addEventListener('click', (e) => {
					if (e.target === modal) {
						modal.style.display = "none";
						document.body.style.overflow = "auto";
					}
				});

				// Show the full description when 'Read More' is clicked
				readMoreBtn.addEventListener('click', () => {
					if (link) {
						window.location.href = link; // Redirect to the book link
					}
				});
			</script>
				
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/browser.min.js"></script>
			<script src="../assets/js/breakpoints.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

	</body>
</html>