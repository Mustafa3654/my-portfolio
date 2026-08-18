<?php
// connection.php
$host = 'localhost';
$dbname = 'portfolio_db';
$username = 'root';     // change if your MySQL uses different user
$password = '';         // add password if needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch all settings data once for global use
$stmt = $pdo->query("SELECT * FROM settings");
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch all skills
$stmt = $pdo->query("SELECT * FROM skills ORDER BY priority ASC");
$skills = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Ensure it's an empty array if fetch fails

// Fetch all services
$stmt = $pdo->query("SELECT * FROM services ORDER BY priority ASC");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Ensure it's an empty array if fetch fails