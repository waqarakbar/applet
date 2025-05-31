<?php
require './inc/auth.php';
require './inc/functions.php';
require './inc/db.php';
require './configs.php';

try {
    // Begin transaction
    $pdo->beginTransaction();

    // Check if 'users' table exists
    $result = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
    if ($result->fetchColumn() === false) {
        // Create 'users' table
        $pdo->exec("
            CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                username TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL
            )
        ");

        // Insert default user 'Admin'
        $hashedPassword = password_hash('admin1234', PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (name, username, password) VALUES (:name, :username, :password)");
        $stmt->execute([
            ':name' => 'Admin',
            ':username' => 'admin',
            ':password' => $hashedPassword
        ]);
    }

    // Check if 'settings' table exists
    $result = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='settings'");
    if ($result->fetchColumn() === false) {
        // Create 'settings' table
        $pdo->exec("
            CREATE TABLE settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                base_url TEXT NOT NULL,
                server_url TEXT NOT NULL,
                client_id TEXT NOT NULL,
                client_secret TEXT NOT NULL,
                sos_key TEXT NOT NULL,
                scope TEXT
            )
        ");
    }

    // Commit transaction
    $pdo->commit();
    $_SESSION['msg'] = "Database tables have been created (if needed) and default user has been added.";
    header('Location:./');

} catch (PDOException $e) {
    // Rollback on error
    $pdo->rollBack();
    die("Database error: " . $e->getMessage());
}
