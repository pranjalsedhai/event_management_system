<?php
$host = "localhost";
// $dbname = "np03cy4a240013";
// $username = "np03cy4a240013";
// $password = "y2HUa02V9V";
$dbname = "event_management";
$username = "root";
$password = "";

try {
    // creating pdo connection
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // enable exception mode for errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // stop script if connection fails
    die("Database connection failed");
}
