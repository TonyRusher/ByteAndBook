<?php
require_once('Conexion.php');
$base = new Conexion();
$conn = $base->getConn();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT IMAGEN from LIBRO_VIRTUAL WHERE ID_LIBRO_VIRTUAL = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();

    if ($image) {
        header("Content-Type: image/jpeg");
        // header("Content-Type: application/pdf");
        echo $image;
    } else {
        echo "Imagen no encontrada.";
    }

    $stmt->close();
}

$conn->close();
?>
