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
    $sql = "SELECT id, name, age, gender, birth_date, birth_place, parent_name, anak_ke, kondisi_anak FROM anak WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $age = $row['age'];
        $gender = $row['gender'];
        $birth_date = $row['birth_date'];
        $birth_place = $row['birth_place'];
        $parent_name = $row['parent_name'];
        $anak_ke = $row['anak_ke'];
        $kondisi_anak = $row['kondisi_anak'];
    } else {
        echo "No record found";
        exit;
    }

    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $birth_place = $_POST['birth_place'];
    $parent_name = $_POST['parent_name'];
    $anak_ke = $_POST['anak_ke'];
    $kondisi_anak = $_POST['kondisi_anak'];

    $sql = "UPDATE anak SET name=?, age=?, gender=?, birth_date=?, birth_place=?, parent_name=?, anak_ke=?, kondisi_anak=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssssi", $name, $age, $gender, $birth_date, $birth_place, $parent_name, $anak_ke, $kondisi_anak, $id);

    if ($stmt->execute()) {
        header("Location: data_anak.php");
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
    <title>Edit Anak</title>
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
        .edit-container select {
            width: 100%;
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
        <h2>Edit Anak</h2>
        <form action="edit_anak.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <label for="age">Usia</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>" required>
            <label for="gender">Jenis Kelamin</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
            </select>
            <label for="birth_date">Tanggal Lahir</label>
            <input type="date" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($birth_date); ?>" required>
            <label for="birth_place">Tempat Lahir</label>
            <input type="text" id="birth_place" name="birth_place" value="<?php echo htmlspecialchars($birth_place); ?>" required>
            
            <label for="parent_name">Parent Name</label>
            <input type="text" id="parent_name" name="parent_name" value="<?php echo htmlspecialchars($parent_name); ?>" required>
            <label for="anak_ke">Anak Ke</label>
            <input type="text" id="anak_ke" name="anak_ke" value="<?php echo htmlspecialchars($anak_ke); ?>" required>
            <label for="kondisi_anak">Kondisi Anak</label>
            <input type="text" id="kondisi_anak" name="kondisi_anak" value="<?php echo htmlspecialchars($kondisi_anak); ?>" required>
            
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>