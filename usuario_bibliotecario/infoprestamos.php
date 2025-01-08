<?php
if (isset($_GET['id'])) {
    $idLibro = intval($_GET['id']);

    require_once('../usuario_global/Conexion.php');
	$base = new Conexion();
	$conn = $base->getConn();

    $sql = "SELECT 
    CONCAT(dp.NOMBRE, ' ', dp.APELLIDO_1, ' ', dp.APELLIDO_2) AS NOMBRE_COMPLETO, 
    p.FECHA_ENTREGA
FROM 
    PRESTAMOS p
JOIN 
    LIBRO_FISICO lf ON p.ID_LIBRO_FISICO = lf.ID_LIBRO_FISICO
JOIN 
    DATOS_LIBRO dl ON lf.ID_DATOS_LIBRO = dl.ID_DATOS_LIBRO
JOIN 
    USUARIOS u ON p.ID_USUARIO = u.ID_USUARIO
JOIN 
    DATOS_PERSONALES dp ON u.ID_DATOS_PERSONALES = dp.ID_DATOS_PERSONALES
WHERE 
    dl.ID_DATOS_LIBRO = ? AND p.ESTADO > 0;
";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idLibro);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Información de los prestamos</h2><ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>Nombre Completo:</strong> " . htmlspecialchars($row['NOMBRE_COMPLETO']) . "</li>";
			echo "<li><strong>Fecha de Entrega:</strong> " . htmlspecialchars($row['FECHA_ENTREGA']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Informacion no encontrada.</p>";
    }
    $conn->close();
} else {
    echo "<p>Error: Usuario no especificado.</p>";
}