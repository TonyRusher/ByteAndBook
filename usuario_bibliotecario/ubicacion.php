<?php
if (isset($_GET['id'])) {
    $idLibro = intval($_GET['id']);

    require_once('../usuario_global/Conexion.php');
	$base = new Conexion();
	$conn = $base->getConn();

    $sql = "SELECT PASILLO, ESTANTE FROM LIBRO_FISICO lf WHERE ID_DATOS_LIBRO = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idLibro);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Ubicacion</h2><ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>Pasillo:</strong> " . htmlspecialchars($row['PASILLO']) . "</li>";
            echo "<li><strong>Estante:</strong> " . htmlspecialchars($row['ESTANTE']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<h1>".$idLibro."</h1>";
        echo "<p>Informacion no encontrada.</p>";
    }

    $conn->close();
} else {
    echo "<p>Error: Usuario no especificado.</p>";
}