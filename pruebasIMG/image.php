<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "image_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT image FROM images WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();

    if ($image) {
        // header("Content-Type: image/jpeg");
        header("Content-Type: application/pdf");
        echo $image;
    } else {
        echo "Image not found.";
    }

    $stmt->close();
}

$conn->close();
?>
