<?php

require './inc/auth.php';
require './inc/functions.php';
require './inc/db.php';
require './configs.php';



// Encrypt data
$base_url = encryptData($_POST['base_url'], SECRET_KEY);
$server_url = encryptData($_POST['server_url'], SECRET_KEY);
$client_id = encryptData($_POST['client_id'], SECRET_KEY);
$client_secret = encryptData($_POST['client_secret'], SECRET_KEY);
$sos_key = encryptData($_POST['sos_key'], SECRET_KEY);
$start_date = $_POST['start_date'];
$scope = encryptData($_POST['scope'], SECRET_KEY);

// Check if a settings record exists
$result = $pdo->query("SELECT id FROM settings LIMIT 1");
if ($result->fetchColumn()) {
    // Update existing settings
    $stmt = $pdo->prepare("
            UPDATE settings SET
                base_url = :base_url,
                server_url = :server_url,
                client_id = :client_id,
                client_secret = :client_secret,
                sos_key = :sos_key,
                start_date = :start_date,
                scope = :scope
            WHERE id = 1
        ");
} else {
    // Insert new settings
    $stmt = $pdo->prepare("
            INSERT INTO settings (id, base_url, server_url, client_id, client_secret, sos_key, start_date, scope)
            VALUES (1, :base_url, :server_url, :client_id, :client_secret, :sos_key, :start_date, :scope)
        ");
}

$stmt->execute([
    ':base_url' => $base_url,
    ':server_url' => $server_url,
    ':client_id' => $client_id,
    ':client_secret' => $client_secret,
    ':sos_key' => $sos_key,
    ':start_date' => $start_date,
    ':scope' => $scope
]);

$_SESSION['msg'] = "Settings saved successfully!";
header('Location: ./settings.php');
