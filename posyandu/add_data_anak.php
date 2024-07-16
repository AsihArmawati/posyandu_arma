<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location : login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "posyandu";


//membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

//cek koneksi
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $birth_place = $_POST['birth_place'];
    $parent_name = $_POST['parent_name'];
    $anak_ke = $_POST['anak_ke'];
    $kondisi_anak = $_POST['kondisi_anak'];

    $sql = "INSERT INTO anak (name, age, gender, birth_date, birth_place, parent_name, anak_ke, kondisi_anak) VALUES ('$name', '$age', '$gender', '$birth_date', '$birth_place', '$parent_name', '$anak_ke', '$kondisi_anak')";
    if ($conn->query($sql) === TRUE) {
        header('Location: data_anak.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Data Anak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin:0;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 15px;
            color: #fff;
            display: block;
        }

        .sidebar a:hover {
            background-color: #575d63;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header h2 {
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="sidebar">
    <ul>
                
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="add_data_ibu.php">Tambah Data Ibu</a></li>
                <li><a href="add_data_anak.php">Tambah Data Anak</a></li>
                <li><a href="add_ibu_hamil.php">Tambah Data Ibu Hamil</a></li>
                <br>
                <li><a href="data_ibu.php">Data Ibu</a></li>
                <li><a href="data_anak.php">Data Anak</a></li>  
                <li><a href="data_ibu_hamil.php">Data Ibu Hamil</a></li>
                <br>
                <li><a href="laporan_ibu_hamil.php">Laporan Ibu Hamil</a></li>
                <li><a href="laporan_ibu.php">Laporan Ibu </a></li>
                <li><a href="laporan_anak.php">Laporan anak </a></li>
                <br>
                <li><a href="logout.php">Logout</a></li>
            </ul>
       
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Tambah data Anak</h2>
        </div> <br>

        <form action="add_data_anak.php" method="post">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" required>

            <label for="age">Usia</label>
            <input type="number" id="age" name="age" required>

            <label for="gender">Jenis Kelamin</label>
            <select id="gender" name="gender" required>
                <option value="Male">Laki-Laki</option>
                <option value="Female">Perempuan</option>
            </select>

            <label for="birth_date">Tanggal Lahir</label>
            <input type="date" id="birth_date" name="birth_date" required>

            <label for="birth_place">Tempat Lahir</label>
            <input type="text" id="birth_place" name="birth_place" required>

            <label for="parent_name">Nama Ibu</label>
            <input type="text" id="parent_name" name="parent_name" required>

            <label for="anak_ke">Anak Ke</label>
            <input type="number" id="anak_ke" name="anak_ke" required>

            <label for="kondisi_anak">Kondisi Anak</label>
            <input type="text" id="kondisi_anak" name="kondisi_anak" required>
            <br><br>
            <button type="submit">Add</button>
        </form>
    </div>
    </div>
    
</body>
</html>