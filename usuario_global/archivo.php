<?php
require_once('../usuario_global/Conexion.php');
$base = new Conexion();
$conn = $base->getConn();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("select ARCHIVO from LIBRO_VIRTUAL WHERE ID_LIBRO_VIRTUAL = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();

    if ($image) {
        // header("Content-Type: image/jpeg");
        header("Content-Type: application/pdf");
		header("Content-Disposition: inline; filename=document.pdf"); // Display inline
        echo $image;
    } else {
        echo "Archivo no encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>
