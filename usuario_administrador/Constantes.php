<?php
	class Constantes {
		public $footer = "<section id='footer'>
							<p class='copyright'>&copy; Untitled. Design: <a href='http://html5up.net'>HTML5 UP</a>.</p>
						</section>";
		
		public $navAdmin = "<nav class='links'>
						<ul>
							<li><a href='registrar_bibliotecario.php'>Registrar</a></li>
							<li><a href='buscar_bibliotecario.php'>Buscar</a></li>
							<li><a href='../usuario_global/cerrarSesion.php'>Cerrar sesión</a></li>
						</ul>
					</nav>";
		
		public $header = "<header id='header'>
					<h1><a href='../usuario_global/index.php'> Byte & Book </a></h1>";
		public $headerEnd = "</header>";

		
							
		
		public $menuAdmin = "<nav class='main'>
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
										<a href='registrar_bibliotecario.php'>
											<h3>Registrar</h3>
											<p>Registra a los nuevos bibliotecarios</p>
										</a>
									</li>
									<li>
										<a href='buscar_bibliotecario.php'>
											<h3>Buscar</h3>
											<p>Revisa y actualiza el perfil de los bibliotecarios</p>
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
			if($tipo == 3){
				echo $this->header;
				echo $this->navAdmin;
				echo $this->menuAdmin;
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