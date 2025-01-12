<?php
class ValoracionLibro {
	private $conn;

	public function __construct($db) {
		$this->conn = $db;
	}

	public function getValoracion($idLibro) {
		// echo "entro a getValoracion";
		$query = "CALL getValoracionLibro($idLibro)";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$result = $row["VALORACION_PROMEDIO"];
		$stmt->close();
		// echo "La valoración del libro es: " . $result;
		return $result ;
	}
}

// Usage example
// try {
// 	$db = new PDO('mysql:host=localhost;dbname=ByteAndBook', 'username', 'password');
// 	$valoracionLibro = new ValoracionLibro($db);
// 	$idLibro = 1; // Example book ID
// 	$valoracion = $valoracionLibro.getValoracion($idLibro);
// 	echo "La valoración del libro es: " . $valoracion;
// } catch (PDOException $e) {
// 	echo "Error: " . $e->getMessage();
// }


?>