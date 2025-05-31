<?php require_once "./inc/auth.php"; ?>
<?php require_once "./inc/functions.php"; ?>
<?php require_once "./inc/db.php"; ?>
<?php require_once "./configs.php"; ?>
<?php

// Fetch existing settings
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

$base_url = $client_id = $client_secret = $sos_key = $scope = $server_url = '';

if ($settings) {
    $base_url = decryptData($settings['base_url'], SECRET_KEY);
    $server_url = decryptData($settings['server_url'], SECRET_KEY);
    $client_id = decryptData($settings['client_id'], SECRET_KEY);
    $client_secret = decryptData($settings['client_secret'], SECRET_KEY);
    $sos_key = decryptData($settings['sos_key'], SECRET_KEY);
    $scope = decryptData($settings['scope'], SECRET_KEY);
}else{
    $_SESSION['msg'] = "Invalid settings, please update your settings and try again";
    header("Location: ./settings.php");
    die('!');
}



$consent_url = $base_url.'/oauth/chooselocation?'.http_build_query([
    'response_type' => 'code',
    'redirect_uri' => $server_url.'/applet/access_token_data.php',
    'client_id' => $client_id,
    'scope' => $scope
]);

header("Location: $consent_url");