<?php
if (isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']);

    require_once('../usuario_global/Conexion.php');
	$base = new Conexion();
	$conn = $base->getConn();

    $sql = "CALL ObtenerAdeudosUsuario($idUsuario)";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Adeudos</h2><ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>" . htmlspecialchars($row['TITULO']) . "</strong> - Entrega vencida desde: " . $row['FECHA_ENTREGA'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No hay libros con adeudos.</p>";
    }

    $conn->close();
} else {
    echo "<p>Error: Usuario no especificado.</p>";
}