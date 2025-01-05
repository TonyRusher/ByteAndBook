<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "image_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, image_name FROM images";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>" . htmlspecialchars($row['image_name']) . "</p>";
        echo "<img src='image.php?id=" . $row['id'] . "' width='300'/>";
    }
} else {
    echo "No images found.";
}

$conn->close();
?>
