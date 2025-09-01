<?php
// results.php - Domain availability checker (mock using DB)
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to register domains.'); location.href='login.php';</script>";
    exit();
}
include 'db.php';
 
$domain_input = mysqli_real_escape_string($conn, $_GET['domain']);
$extensions = ['.com', '.net', '.org', '.io', '.app']; // Popular extensions
$results = [];
 
foreach ($extensions as $ext) {
    $full_domain = $domain_input . $ext;
    list($name, $extension) = explode('.', $full_domain, 2);
    $sql = "SELECT COUNT(*) as count FROM domains WHERE domain_name = '$name' AND extension = '.$extension'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $available = $row['count'] == 0;
    $results[$full_domain] = $available;
}
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selected_domain = $_POST['domain'];
    list($name, $extension) = explode('.', $selected_domain, 2);
    $user_id = $_SESSION['user_id'];
    $reg_date = date('Y-m-d');
    $exp_date = date('Y-m-d', strtotime('+1 year'));
 
    $sql = "INSERT INTO domains (user_id, domain_name, extension, registration_date, expiration_date) VALUES ($user_id, '$name', '$extension', '$reg_date', '$exp_date')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Domain registered!'); location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domain Search Results</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #007bff; }
        ul { list-style: none; padding: 0; }
        li { padding: 20px; margin: 10px 0; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; font-size: 20px; transition: box-shadow 0.3s; }
        li.available { background: #d4edda; color: #155724; }
        li.taken { background: #f8d7da; color: #721c24; }
        li:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; transition: background 0.3s; }
        button:hover { background: #0056b3; }
        button:disabled { background: #6c757d; cursor: not-allowed; }
        .back { text-align: center; margin-top: 20px; }
        a { color: #007bff; text-decoration: none; font-size: 18px; }
        @media (max-width: 600px) { li { flex-direction: column; text-align: center; } button { margin-top: 10px; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Search Results for "<?php echo htmlspecialchars($domain_input); ?>"</h2>
        <ul>
            <?php foreach ($results as $domain => $available): ?>
                <li class="<?php echo $available ? 'available' : 'taken'; ?>">
                    <?php echo htmlspecialchars($domain); ?> - <?php echo $available ? 'Available' : 'Taken'; ?>
                    <?php if ($available): ?>
                        <form method="POST" style="margin:0;">
                            <input type="hidden" name="domain" value="<?php echo htmlspecialchars($domain); ?>">
                            <button type="submit">Register</button>
                        </form>
                    <?php else: ?>
                        <button disabled>Taken</button>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="back"><a href="index.php">Back to Search</a></div>
    </div>
</body>
</html>
