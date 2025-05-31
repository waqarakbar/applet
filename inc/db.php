<?php

// Database file path
$dbFile = './database/ghl_applet_db.sqlite';

try {
    // Create (connect to) SQLite database
    $pdo = new PDO("sqlite:" . $dbFile);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Handle error
    die("Connection failed: " . $e->getMessage());
}

// $pdo is now ready to use in other PHP files