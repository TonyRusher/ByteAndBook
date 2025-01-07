<?php
if (isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']);
    require_once('../usuario_global/Conexion.php');
	$base = new Conexion();
	$conn = $base->getConn();
// Consulta para obtener los préstamos del usuario con cálculo de deuda
$sql = "SELECT 
            ID_PRESTAMO,
            l.TITULO,
            FECHA_ENTREGA,
            FECHA_DEVOLUCION,
            ESTADO,
            GREATEST(DATEDIFF(CURDATE(), FECHA_ENTREGA), 0) AS DIAS_ATRASO,
            GREATEST(DATEDIFF(CURDATE(), FECHA_ENTREGA), 0) * 25 AS MONTO
        FROM PRESTAMOS p
        INNER JOIN LIBRO_FISICO lf ON p.ID_LIBRO_FISICO = lf.ID_LIBRO_FISICO
	    INNER JOIN DATOS_LIBRO l ON lf.ID_LIBRO_FISICO = l.ID_DATOS_LIBRO
        WHERE ID_USUARIO = ? AND ESTADO = 3";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si hay resultados
if ($result->num_rows > 0) {
    echo "<h3>Deudas Pendientes</h3>";
    echo "<table border='1' style='width:100%; text-align: left;'>";
    echo "<thead>
            <tr>
                <th>Titulo</th>
                <th>Fecha Entrega</th>
                <th>Fecha Devolución</th>
                <th>Días de Atraso</th>
                <th>Monto</th>
                <th>Acción</th>
            </tr>
          </thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        $idPrestamo = $row['ID_PRESTAMO'];
        $idLibro = $row['TITULO'];
        $fechaEntrega = htmlspecialchars($row['FECHA_ENTREGA']);
        $fechaDevolucion = htmlspecialchars($row['FECHA_DEVOLUCION']);
        $diasAtraso = $row['DIAS_ATRASO'];
        $monto = $row['MONTO'];

        echo "<tr>
                <td>$idLibro</td>
                <td>$fechaEntrega</td>
                <td>" . ($fechaDevolucion ? $fechaDevolucion : "Pendiente") . "</td>
                <td>$diasAtraso</td>
                <td>\$$monto</td>
                <td>
                    <form method='POST' action='pagar_deuda.php'>
                        <input type='hidden' name='id_prestamo' value='$idPrestamo'>
                        <button type='submit'>Pagar</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No hay deudas pendientes.</p>";
}
}