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

$sql = "SELECT id, name, nama_suami, age, address, phone, date_registered, jenis_kontrasepsi FROM ibu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Ibu</title>
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
        .table-container {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions a {
            text-decoration: none;
            color: #fff;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
        }
        .actions .edit {
            background-color: #007bff;
        }
        .actions .delete {
            background-color: #dc3545;
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


            <h2>Data Ibu</h2>
            <div class="user-info">
                <img src="img/asing.jpg" alt="User Avatar">
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Nama Suami</th>
                        <th>Umur</th>
                        <th>Alamat</th>
                        <th>Phone</th>
                        <th>Tanggal Registrasi</th>
                        <th>Jenis Kontrasepsi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["id"]. "</td>
                                    <td>" . $row["name"]. "</td>
                                    <td>" . $row["nama_suami"]. "</td>
                                    <td>" . $row["age"]. "</td>
                                    <td>" . $row["address"]. "</td>
                                    <td>" . $row["phone"]. "</td>
                                    <td>" . $row["date_registered"]. "</td>
                                    <td>" . $row["jenis_kontrasepsi"]. "</td>
                                    <td class='actions'>
                                        <a href='edit_ibu.php?id=" . $row["id"]. "' class='edit'><i class='fas fa-edit'></i></a>
                                        <a href='delete_ibu.php?id=" . $row["id"]. "' class='delete' onclick='return confirm(\"Are you sure you want to delete this item?\");'><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No data found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>