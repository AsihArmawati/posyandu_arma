<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
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


$ibu_count = $conn->query("SELECT COUNT(*) AS count FROM ibu")->fetch_assoc()['count'];
$anak_count = $conn->query("SELECT COUNT(*) AS count FROM anak")->fetch_assoc()['count'];
$ibu_hamil_count = $conn->query("SELECT COUNT(*) AS count FROM ibu_hamil")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard</title>
</head>

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
        .header .user-info {
            display: flex;
            align-items: center;
        }
        .header .user-info img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .header .user-info span {
            font-size: 16px;
            color: #333;
        }
        .cards {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .card {
            width: 30%;
            background-color: pink;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .card h3 {
            font-size: 24px;
            margin: 10px 0;
        }
        .card i {
            font-size: 40px;
            color: #007bff;
        }
        .card .card-text {
            font-size: 20px;
            margin-top: 10px;
        }
    </style>

<body>
    <div class="container">
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
            <h1>Dashboard Posyandu</h1>
            <div class="dashboard-cards">
                <div class="card">
                    <h2>Data Ibu</h2>
                    <p><?php echo $ibu_count; ?></p>
                </div>
                <br><br>
                <div class="card">
                    <h2>Data Anak</h2>
                    <p><?php echo $anak_count; ?></p>
                </div>
                <br><br>
                <div class="card">
                    <h2>Data Ibu Hamil</h2>
                    <p><?php echo $ibu_hamil_count; ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>