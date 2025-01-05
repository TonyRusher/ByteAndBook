<?php
require_once('../usuario_global/Conexion.php');
$base = new Conexion();
$conn = $base->getConn();

session_start();
if(isset($_GET["id"])){
	$idLibroVirtual = $_GET["id"];
	$idUsuario = $_SESSION["ID_USUARIO"];
	echo "idLibro = ".$idLibroVirtual;
	echo "idUsuario = ".$idUsuario;
	
	$stmt = "CALL AgregarValoracionLibro(?, ?)";
	$sp = $conn->prepare($stmt);
	$sp->bind_param("ii", $idLibroVirtual, $idUsuario);
	$sp->execute();
	$sp->close();
	
	
	
	
	header("Location: ../usuario_global/archivo.php?id=$idLibroVirtual.php");
	exit();
}



$conn->close();

?>