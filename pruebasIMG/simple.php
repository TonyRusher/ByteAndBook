<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        echo "File uploaded successfully!<br>";
        echo "File name: " . $_FILES['image']['name'] . "<br>";
        echo "File size: " . $_FILES['image']['size'] . " bytes<br>";
    } else {
        echo "Error in file upload: " . $_FILES['image']['error'] . "<br>";
    }
}
?>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" required>
    <button type="submit">Upload</button>
</form>
