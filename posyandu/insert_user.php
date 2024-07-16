<?php
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "posyandu";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function insertUser($conn, $username, $password) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        echo "User '$username' created successfully.<br>";
    } else {
        echo "Error: " . $stmt->error . "<br>";
    }

    $stmt->close();
}


insertUser($conn, 'admin', 'password123');
insertUser($conn, 'user1', 'password456');
insertUser($conn, 'user2', 'password789');

$conn->close();
?>