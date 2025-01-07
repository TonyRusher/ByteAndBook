<?php
if (isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']);
    require_once('../usuario_global/Conexion.php');
	$base = new Conexion();
	$conn = $base->getConn();

    $sql = "CALL ObtenerDeudasUsuario($idUsuario)";
    $result = $conn->query($sql);

    $totalDeuda = 0;

    if ($result->num_rows > 0) {
        echo "<h2>Deudas</h2><ul>";
        while ($row = $result->fetch_assoc()) {
            $diasAtraso = intval($row['dias_atraso']);
            $deuda = $diasAtraso * 25;
            $totalDeuda += $deuda;
            echo "<li><strong>" . htmlspecialchars($row['TITULO']) . "</strong> - Días de atraso: " . $diasAtraso . ", Monto: $" . $deuda . "</li>";
        }
        echo "</ul>";
        echo "<h3>Total Deuda: $" . $totalDeuda . "</h3>";
    } else {
        echo "<p>No hay deudas pendientes.</p>";
    }

    $conn->close();
} else {
    echo "<p>Error: Usuario no especificado.</p>";
}