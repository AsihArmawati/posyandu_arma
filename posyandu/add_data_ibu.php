<?php
session_start();

//cek user
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "posyandu";

// buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nama_suami = $_POST['nama_suami'];
    $alamat = $_POST['alamat'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $age = $_POST['age']; 
    $phone = $_POST['phone']; 
    $jenis_kontrasepsi = $_POST['jenis_kontrasepsi']; 

    // hubungkan ke database
    $sql = "INSERT INTO ibu (name, nama_suami, address, date_registered, age, phone, jenis_kontrasepsi) VALUES ('$nama', '$nama_suami', '$alamat', '$tgl_lahir', '$age', '$phone', '$jenis_kontrasepsi')";
    if ($conn->query($sql) === TRUE) {
        header('Location: data_ibu.php');
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
    <title>Add Data Ibu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
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
        input[type="number"] {
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
            <h2>Tambah Data Ibu</h2> <br>
        </div> <br>
        <form action="add_data_ibu.php" method="post">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" required>
            <label for="nama_suami">Nama Suami</label>
            <input type="text" id="nama_suami" name="nama_suami" required>
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" required>
            <label for="tgl_lahir">Tanggal Registrasi</label>
            <input type="date" id="tgl_lahir" name="tgl_lahir" required>
            <label for="age">Umur</label>
            <input type="number" id="age" name="age" required min="0">
            <label for="phone">Phone</label>
            <input type="number" id="phone" name="phone" required min="0">
            <label for="jenis_kontrasepsi">Jenis Kontrasepsi</label>
            <input type="text" id="jenis_kontrasepsi" name="jenis_kontrasepsi" required>
            <br><br>
            <button type="submit">Add</button>
        </form>
    </div>
</body>
</html>