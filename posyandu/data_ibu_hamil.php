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

$sql = "SELECT id, name, age, pregnancy_age, due_date FROM ibu_hamil";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Ibu Hamil</title>
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
        .action-buttons a {
            text-decoration: none;
            padding: 5px 10px;
            margin: 0 2px;
            border-radius: 4px;
        }
        .action-buttons .edit {
            background-color: #4CAF50;
            color: white;
        }
        .action-buttons .delete {
            background-color: #f44336;
            color: white;
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
            <h2>Data Ibu Hamil</h2>
            <div class="user-info">
                <img src="img/asing.jpg" alt="User Image">
                <span>Admin</span>
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Usia Kehamilan</th>
                        <th>Perkiraan Lahir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['age'] . "</td>";
                            echo "<td>" . $row['pregnancy_age'] . "</td>";
                            echo "<td>" . $row['due_date'] . "</td>";
                            echo "<td class='action-buttons'>
                                    <a href='edit_ibu_hamil.php?id=" . $row['id'] . "' class='edit'><i class='fas fa-edit'></i></a>
                                    <a href='delete_ibu_hamil.php?id=" . $row['id'] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this item?\");'><i class='fas fa-trash-alt'></i></a>
                                  </td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='6'>No data found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>