<?php
class Conexion{
	
	
	public function getConn(){
		// $conn = mysqli_connect("localhost", "grupok", "2024cdn#7", "proyectoequk", "3306");
		$conn = mysqli_connect("localhost", "root", "", "ByteAndBook");
		// $conn = mysqli_connect("localhost", "id22380908_gerente", "Gerente_1", "id22380908_plumeria");
		return $conn;
	}
}


?>