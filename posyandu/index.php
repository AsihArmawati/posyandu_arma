<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

header("Location: dashboard.php");
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
            padding: 50px;
        }
        .logout {
            margin-top: 20px;
        }
    </style>
    
</head>
<body>
    <div class="container">
        <h1>Welcome to the Posyandu System</h1>
        <p>You are logged in as <?php echo htmlspecialchars($_SESSION['username']); ?>.</p>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>