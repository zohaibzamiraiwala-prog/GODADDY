<?php
// dashboard.php - User dashboard for managing domains
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href='login.php';</script>";
    exit();
}
include 'db.php';
 
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM domains WHERE user_id = $user_id";
$result = $conn->query($sql);
 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
    $domain_id = $_POST['domain_id'];
    $sql_delete = "DELETE FROM domains WHERE id = $domain_id AND user_id = $user_id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>alert('Domain removed!'); location.href='dashboard.php';</script>";
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
    <title>Dashboard - Manage Domains</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; margin: 0; padding: 20px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #007bff; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        tr:hover { background: #f1f1f1; }
        button { background: #dc3545; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; transition: background 0.3s; margin-right: 5px; }
        button:hover { background: #c82333; }
        .renew, .transfer { background: #ffc107; color: #212529; }
        .renew:hover, .transfer:hover { background: #e0a800; }
        .logout { text-align: center; margin-top: 30px; }
        a { color: #007bff; text-decoration: none; font-size: 18px; }
        @media (max-width: 768px) { table { font-size: 14px; } th, td { padding: 10px; } }
    </style>
    <script>
        function renew() { alert('Renewal functionality coming soon!'); }
        function transfer() { alert('Transfer functionality coming soon!'); }
    </script>
</head>
<body>
    <div class="container">
        <h2>Your Registered Domains</h2>
        <table>
            <tr>
                <th>Domain</th>
                <th>Registration Date</th>
                <th>Expiration Date</th>
                <th>Actions</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['domain_name'] . $row['extension']); ?></td>
                        <td><?php echo $row['registration_date']; ?></td>
                        <td><?php echo $row['expiration_date']; ?></td>
                        <td>
                            <button class="renew" onclick="renew()">Renew</button>
                            <button class="transfer" onclick="transfer()">Transfer</button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="domain_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center;">No domains registered yet.</td></tr>
            <?php endif; ?>
        </table>
        <div class="logout"><a href="logout.php">Logout</a> | <a href="index.php">Back to Home</a></div>
    </div>
</body>
</html>
