<?php
// index.php - Homepage with domain search bar
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domain Platform - Find Your Perfect Domain</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background: #f8f9fa; color: #333; }
        header { background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 60px 20px; text-align: center; }
        h1 { font-size: 48px; margin: 0; }
        .search-bar { margin: 20px auto; max-width: 800px; display: flex; }
        input[type="text"] { flex: 1; padding: 20px; font-size: 24px; border: none; border-radius: 8px 0 0 8px; }
        button { background: #28a745; color: white; padding: 20px 40px; font-size: 24px; border: none; border-radius: 0 8px 8px 0; cursor: pointer; transition: background 0.3s; }
        button:hover { background: #218838; }
        .extensions { margin: 20px 0; font-size: 18px; }
        .extensions span { background: rgba(255,255,255,0.2); padding: 5px 10px; border-radius: 5px; margin: 0 5px; }
        .promotions { padding: 40px 20px; display: flex; justify-content: space-around; flex-wrap: wrap; }
        .promo { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); width: 300px; margin: 10px; text-align: center; transition: transform 0.3s; }
        .promo:hover { transform: translateY(-5px); }
        .promo h3 { color: #007bff; }
        nav { position: absolute; top: 20px; right: 20px; }
        nav a { color: white; margin: 0 10px; text-decoration: none; font-size: 18px; }
        nav a:hover { text-decoration: underline; }
        @media (max-width: 768px) { h1 { font-size: 32px; } .search-bar { flex-direction: column; } input[type="text"] { border-radius: 8px; margin-bottom: 10px; } button { border-radius: 8px; } .promotions { flex-direction: column; align-items: center; } }
    </style>
</head>
<body>
    <header>
        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
        <h1>Find Your Perfect Domain</h1>
        <form action="results.php" method="GET" class="search-bar">
            <input type="text" name="domain" placeholder="Enter domain name..." required>
            <button type="submit">Search</button>
        </form>
        <div class="extensions">Popular extensions: <span>.com</span> <span>.net</span> <span>.org</span> <span>.io</span> <span>.app</span></div>
    </header>
    <section class="promotions">
        <div class="promo">
            <h3>.com Domains</h3>
            <p>Starting at $9.99/year</p>
        </div>
        <div class="promo">
            <h3>Special Offer</h3>
            <p>Get 20% off on first registration!</p>
        </div>
        <div class="promo">
            <h3>Premium Plans</h3>
            <p>Unlimited domains for $99/year</p>
        </div>
    </section>
</body>
</html>
