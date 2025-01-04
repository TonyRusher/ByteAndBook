<?php
class Conexion{
	
	
	public function getConn(){
		try{
			$server = "localhost";
			$user = "root";
			$pass = "";
			$bd = "byteandbook";
			$conn = new mysqli($server, $user, $pass, $bd);
			if($conn->connect_error){
				die("Error en la conexión: ".$conn->connect_error);
			}
			return $conn;
		}catch(Exception $e){
			die("Error en la conexión: ".$e->getMessage());
		}
		
	}
}


?>