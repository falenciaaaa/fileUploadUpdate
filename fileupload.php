<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'db';

$conn = new mysqli($host, $username, $password, $dbname);

// Fetch data from the database
$sql = "SELECT email, file_path FROM upload";
$result = $conn->query($sql);

$uploads = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $uploads[] = $row;
    }
}

$conn->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email";
        exit;
    }

    $fileType = ['image/jpeg', 'image/png'];
    if (!in_array($_FILES["file"]["type"], $fileType)) {
        echo "Only JPEG and PNG files are allowed";
        exit;
    }

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        $stmt = $conn->prepare("INSERT INTO upload (email, file_path) VALUES (?, ?)");
        $stmt->bind_param('ss', $email, $targetFile);

        if ($stmt->execute()) {
            echo "File successfully uploaded and data stored.";
        } else {
            echo "Error storing data!";
        }

        $stmt->close();
        $conn->close();

    } else {
        echo "Error uploading file";
    }
}
?>