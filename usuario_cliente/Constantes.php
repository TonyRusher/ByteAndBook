<?php
	class Constantes {
		public $footer = "<section id='footer'>
							<p class='copyright'>&copy; Untitled. Design: <a href='http://html5up.net'>HTML5 UP</a>.</p>
						</section>";
		
		public $navUsuario = "<nav class='links'>
						<ul>
							<li><a href='mi_cuenta_usuario.php'>Mi cuenta</a></li>
							<li><a href='adeudos.php'>Adeudos</a></li>
							<li><a href='historial.php'>Historial</a></li>
							<li><a href='plus.php'>Plus</a></li>
							<li><a href='cerrarSesion.php'>Cerrar sesión</a></li>
						</ul>
					</nav>";
		
		public $header = "<header id='header'>
					<h1><a href='../usuario_global/index.php'> Byte & Book </a></h1>";
		public $headerEnd = "</header>";

		
							
		
		public $menuUsuario = "<nav class='main'>
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
										<a href='mi_cuenta_usuario.php'>
											<h3>Mi cuenta</h3>
											<p>Visualiza tus datos</p>
										</a>
									</li>
									<li>
										<a href='adeudos.php'>
											<h3>Adeudos</h3>
											<p>Checa tus adeudos</p>
										</a>
									</li>
									<li>
										<a href='historial.php'>
											<h3>Historial</h3>
											<p>Ve tu historial de libros</p>
										</a>
									</li>
									<li>
										<a href='plus.php'>
											<h3>Version plus</h3>
											<p>Accede a libros digitales con recomendaciones</p>
										</a>
									</li>
									<li>
										<a href='cerrarSesion.php'>
											<h3>Cerrar sesión</h3>
											<p>Finaliza tu sesión</p>
										</a>
									</li>
								</ul>
							</section>";
		
									
		public function getHeader($tipo){
			$ans = "";
			if($tipo == 1){
				echo $this->header;
				echo $this->navUsuario;
				echo $this->menuUsuario;
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
			<link rel='stylesheet' href='style.css' />
		<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
		<script>
			import Swal from 'sweetalert2/dist/sweetalert2.js'
			import 'sweetalert2/src/sweetalert2.scss'
		</script>'";
		}
	}
?>