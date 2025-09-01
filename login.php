<?php
// login.php - User login page
session_start();
if (isset($_SESSION['user_id'])) {
    echo "<script>location.href='dashboard.php';</script>";
    exit();
}
include 'db.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
 
    $sql = "SELECT id, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            echo "<script>location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Domain Platform</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #f5f7fa, #c3cfe2); margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 400px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; font-size: 28px; }
        form { display: flex; flex-direction: column; }
        input { margin: 10px 0; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; transition: border 0.3s; }
        input:focus { border-color: #007bff; outline: none; }
        button { background: #007bff; color: white; padding: 15px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; transition: background 0.3s; }
        button:hover { background: #0056b3; }
        p { text-align: center; margin-top: 20px; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        @media (max-width: 600px) { .container { width: 90%; padding: 20px; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
