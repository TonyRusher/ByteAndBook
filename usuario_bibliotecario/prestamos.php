<?php
if (isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']);

    require_once('../usuario_global/Conexion.php');
	$base = new Conexion();
	$conn = $base->getConn();

    $sql = "CALL ObtenerPrestamosUsuarioBusqueda($idUsuario)";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Préstamos</h2><ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>" . htmlspecialchars($row['TITULO']) . "</strong> - <br>Prestado el: " . $row['FECHA_PRESTAMO'] . "<br> Entregar antes de: " . $row['FECHA_ENTREGA'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No hay libros en préstamo.</p>";
    }

    $conn->close();
} else {
    echo "<p>Error: Usuario no especificado.</p>";
}