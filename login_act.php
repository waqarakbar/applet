<?php
session_start();
require './inc/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Retrieve user data
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = :username LIMIT 1");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login success
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        $_SESSION['msg'] = "Login successfull";
        header('Location: ./');
        exit;
    } else {
        // Login failed
        $_SESSION['msg'] = "Invalid username or password.";
        header("Location: ./login.php");
    }
}
