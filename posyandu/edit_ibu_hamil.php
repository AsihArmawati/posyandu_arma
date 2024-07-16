<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "posyandu";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM ibu_hamil WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$name = $row['name'];
$age = $row['age'];
$pregnancy_age = $row['pregnancy_age'];
$due_date = $row['due_date'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $pregnancy_age = $_POST['pregnancy_age'];
    $due_date = $_POST['due_date'];

    $sql = "UPDATE ibu_hamil SET name=?, age=?, pregnancy_age=?, due_date=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissi", $name, $age, $pregnancy_age, $due_date, $id);

    if ($stmt->execute()) {
        header("Location: data_ibu_hamil.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Ibu Hamil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
            margin: 0;
        }
        .edit-container {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .edit-container h2 {
            margin: 0 0 20px;
            text-align: center;
        }
        .edit-container input[type="text"],
        .edit-container input[type="number"],
        .edit-container input[type="date"] {
            width: 93%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .edit-container button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Data Ibu Hamil</h2>
        <form action="" method="post">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" value="<?php echo $name; ?>" required>

            <label for="age">Umur</label>
            <input type="number" name="age" id="age" value="<?php echo $age; ?>" required>

            <label for="pregnancy_age">Usia Kehamilan</label>
            <input type="number" name="pregnancy_age" id="pregnancy_age" value="<?php echo $pregnancy_age; ?>" required>

            <label for="due_date">Perkiraan Lahir</label>
            <input type="date" name="due_date" id="due_date" value="<?php echo $due_date; ?>" required>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>