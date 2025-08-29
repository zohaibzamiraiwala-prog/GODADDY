<?php
// create_tables.php - Separate file for creating SQL tables (pro level with indexes, constraints)
include 'db.php';
 
// Create users table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(30),
    last_name VARCHAR(30),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(username),
    INDEX(email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
 
if ($conn->query($sql_users) === TRUE) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}
 
// Create domains table
$sql_domains = "CREATE TABLE IF NOT EXISTS domains (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    domain_name VARCHAR(50) NOT NULL,
    extension VARCHAR(10) NOT NULL,
    registration_date DATE NOT NULL,
    expiration_date DATE NOT NULL,
    status ENUM('active', 'expired', 'pending') DEFAULT 'active',
    UNIQUE KEY unique_domain (domain_name, extension),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX(user_id),
    INDEX(domain_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
 
if ($conn->query($sql_domains) === TRUE) {
    echo "Table 'domains' created successfully.<br>";
} else {
    echo "Error creating domains table: " . $conn->error . "<br>";
}
 
$conn->close();
?>
