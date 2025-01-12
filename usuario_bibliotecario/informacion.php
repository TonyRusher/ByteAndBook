<?php
if (isset($_GET['id'])) {
    $idLibro = intval($_GET['id']);

    require_once('../usuario_global/Conexion.php');
	$base = new Conexion();
	$conn = $base->getConn();

    $sql = "SELECT dl.ISBN,dl.EDITORIAL,dl.EDICION,dl.FECHA_PUBLICACION,dl.IDIOMA,dl.AUTORES 
FROM DATOS_LIBRO dl 
WHERE ID_DATOS_LIBRO = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idLibro);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Información</h2><ul>";
        while ($row = $result->fetch_assoc()) {
			echo "<li><strong>ISBN:</strong> " . htmlspecialchars(number_format($row['ISBN'], 0, '', '')) . "</li>";
            // echo "<li><strong>Genero:</strong> " . htmlspecialchars($row['NOMBRE_GENERO']) . "</li>";
            echo "<li><strong>Editorial:</strong> " . htmlspecialchars($row['EDITORIAL']) . "</li>";
            echo "<li><strong>Edicion:</strong> " . htmlspecialchars($row['EDICION']) . "</li>";
            echo "<li><strong>Fecha de Publicacion:</strong> " . htmlspecialchars($row['FECHA_PUBLICACION']) . "</li>";
            echo "<li><strong>Idioma:</strong> " . htmlspecialchars($row['IDIOMA']) . "</li>";
            echo "<li><strong>Autores:</strong> " . htmlspecialchars($row['AUTORES']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Informacion no encontrada</p>";
    }
    $conn->close();
} else {
    echo "<p>Error: Usuario no especificado.</p>";
}