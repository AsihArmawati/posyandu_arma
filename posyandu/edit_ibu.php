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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT id, name, nama_suami, age, address, phone, date_registered, jenis_kontrasepsi FROM ibu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $nama_suami = $row['nama_suami'];
        $age = $row['age'];
        $address = $row['address'];
        $phone = $row['phone'];
        $date_registered = $row['date_registered'];
        $jenis_kontrasepsi = $row['jenis_kontrasepsi'];
    } else {
        echo "No record found";
        exit;
    }

    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $nama_suami = $_POST['nama_suami'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $date_registerd = $_POST['date_registered'];
    $jenis_kontrasepsi = $_POST['jenis_kontrasepsi'];

    $sql = "UPDATE ibu SET name=?, nama_suami=?, age=?, address=?, phone=?, date_registered=?, jenis_kontrasepsi=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissssi", $name, $nama_suami, $age, $address, $phone, $date_registered, $jenis_kontrasepsi, $id);

    if ($stmt->execute()) {
        header("Location: data_ibu.php");
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
    <title>Edit Ibu</title>
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
        .edit-container input[type="number"] {
            width: 93%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .edit-container button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
        .edit-container button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Ibu</h2>
        <form action="edit_ibu.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <label for="nama_suami">Nama Suami</label>
            <input type="text" id="nama_suami" name="nama_suami" value="<?php echo htmlspecialchars($nama_suami); ?>" required>
            <label for="age">Age</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>" required>
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
            <label for="date_registered">Tanggal Registrasi</label>
            <input type="text" id="date_registered" name="date_registered" value="<?php echo htmlspecialchars($date_registered); ?>" required>
            <label for="jenis_kontrasepsi">Jenis Kontrasepsi</label>
            <input type="text" id="jenis_kontrasepsi" name="jenis_kontrasepsi" value="<?php echo htmlspecialchars($jenis_kontrasepsi); ?>" required>
            
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>