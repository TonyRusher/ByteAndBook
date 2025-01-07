<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_prestamo'])) {
    require_once('../usuario_global/Conexion.php');
    $base = new Conexion();
    $conn = $base->getConn();

    $idPrestamo = intval($_POST['id_prestamo']);

    // Actualizar el estado del préstamo
    $sql = "UPDATE PRESTAMOS SET ESTADO = 0 WHERE ID_PRESTAMO = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPrestamo);

    if ($stmt->execute()) {
        echo "<script>alert('Deuda perdonada con éxito.');</script>";
    } else {
        echo "<script>alert('Error al perdonar la deuda: " . $stmt->error . "');</script>";
    }

    $conn->close();
    header("Location: busqueda_usuarios.php"); // Redirige de vuelta a la página de deudas
    exit;
}
?>
