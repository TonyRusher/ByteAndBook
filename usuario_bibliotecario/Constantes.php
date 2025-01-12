<?php
	class Constantes {
		public $footer = "<section id='footer'>
							<p class='copyright'>&copy; Untitled. Design: <a href='http://html5up.net'>HTML5 UP</a>.</p>
						</section>";
		
		public $navBibliotecario = "<nav class='links'>
						<ul>
							<li><a href='registrar_prestamo.php'>Préstamos</a></li>
							<li><a href='libros.php'>Libros</a></li>
							<li><a href='busqueda_usuarios.php'>Buscar usuarios</a></li>
							<li><a href='registrar_usuarios.php'>Registrar usuario</a></li>
							<li><a href='registrar_libro.php'>Registrar Libro</a></li>
							<li><a href='../usuario_global/cerrarSesion.php'>Cerrar sesión</a></li>
						</ul>
					</nav>";
		
		public $header = "<header id='header'>
					<h1><a href='../usuario_global/index.php'> Byte & Book </a></h1>";
		public $headerEnd = "</header>";

		
							
		
		public $menuBibliotecario = "<nav class='main'>
									<ul>
										<li class='menu'>
											<a class='fa-bars' href='#menu'>Menu</a>
										</li>
									</ul>
								</nav>
						<section id='menu'>
							<section>
								<ul class='links'>
									<li>
										<a href='registrar_prestamo.php'>
											<h3>Préstamos</h3>
											<p>Registra los préstamos</p>
										</a>
									</li>
									<li>
										<a href='registrar_devolucion.php'>
											<h3>Devoluciones</h3>
											<p>Registra las devoluciones</p>
										</a>
									</li>
									<li>
										<a href='registrar_usuarios.php'>
											<h3>Registrar Usuarios</h3>
											<p>Registra a los nuevos usuarios</p>
										</a>
									</li>
									<li>
										<a href='libros.php'>
											<h3>Libros</h3>
											<p>Agrega, modifica o visualiza los libros</p>
										</a>
									</li>
									<li>
										<a href='mi_cuenta_bibliotecario.php'>
											<h3>Mi cuenta</h3>
											<p>Revisa y actualiza tu perfil</p>
										</a>
									</li>
									<li>
										<a href='busqueda_usuario.php'>
											<h3>Buscar usuarios</h3>
											<p>Revisa y actualiza el perfil de los usuarios</p>
										</a>
									</li>
									<li>
										<a href='../usuario_global/cerrarSesion.php'>
											<h3>Cerrar sesión</h3>
											<p>Finaliza tu sesión</p>
										</a>
									</li>
								</ul>
							</section>";
		
									
		public function getHeader($tipo){
			$ans = "";
			if($tipo == 2){
				echo $this->header;
				echo $this->navBibliotecario;
				echo $this->menuBibliotecario;
				echo $this->headerEnd;
			}else{
				echo $this->header;
				echo $this->headerEnd;
				// header("Location: index.php");
				// exit();
			}
		}
		
			
		public function getImports(){
			echo "<link rel='stylesheet' href='../assets/css/main.css' />
			<link rel='stylesheet' href='../style.css' />
		<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
		<script>
			import Swal from 'sweetalert2/dist/sweetalert2.js'
			import 'sweetalert2/src/sweetalert2.scss'
		</script>";
		}
	}
?>