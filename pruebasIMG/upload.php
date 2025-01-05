<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "image_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($imageTmpName);
		if ($imageData === false) {
			echo "Error reading the file data.";
		} else {
			echo "File data successfully read. Size: " . strlen($imageData) . " bytes.";
		}
		echo "<br>";
		// echod bin2hex($imageData);
        // Prepare the SQL query to insert image data
		$stmt = $conn->prepare("INSERT INTO images (image_name, image) VALUES (?, ?)");
		$stmt->bind_param("ss", $imageName, $imageData);
		
		if ($stmt->execute()) {
			echo "Image uploaded and stored in database successfully!";
		} else {
			echo "Failed to upload image to database: " . $stmt->error;
		}
        $stmt->close();
    } else {
        echo "Error in file upload.";
    }
}

$conn->close();
?>
