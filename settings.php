<?php require_once "./inc/auth.php"; ?>
<?php require_once "./inc/functions.php"; ?>
<?php require_once "./inc/db.php"; ?>
<?php require_once "./configs.php"; ?>
<?php

// Fetch existing settings
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

$base_url = $client_id = $client_secret = $sos_key = $scope = '';

if ($settings) {
    $base_url = decryptData($settings['base_url'], SECRET_KEY);
    $client_id = decryptData($settings['client_id'], SECRET_KEY);
    $client_secret = decryptData($settings['client_secret'], SECRET_KEY);
    $sos_key = decryptData($settings['sos_key'], SECRET_KEY);
    $scope = decryptData($settings['scope'], SECRET_KEY);
}

?>
<?php require_once "./inc/header.php"; ?>
<div class="row">
    <div class="col-md-12">
        <h1>Settings</h1>
    </div>
</div>


<div class="row">
    <div class="col-md-12">

        <form action="settings_save.php" method="POST">

            <div class="mb-3">
                <label for="base_url" class="form-label">Base URL</label>
                <input type="text" class="form-control" id="base_url" name="base_url" value="<?php echo $base_url; ?>" required>
            </div>

            <div class="mb-3">
                <label for="client_id" class="form-label">Client ID</label>
                <input type="text" class="form-control" id="client_id" name="client_id" value="<?php echo $client_id; ?>"  required>
            </div>

            <div class="mb-3">
                <label for="client_secret" class="form-label">Client Secret</label>
                <input type="text" class="form-control" id="client_secret" name="client_secret" value="<?php echo $client_secret; ?>" required>
            </div>

            <div class="mb-3">
                <label for="sos_key" class="form-label">SOS Key</label>
                <input type="text" class="form-control" id="sos_key" name="sos_key" value="<?php echo $sos_key; ?>" required>
            </div>

            <div class="mb-3">
                <label for="scope" class="form-label">Scope</label>
                <textarea class="form-control" id="scope" name="scope" rows="4"><?php echo $scope; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>

    </div>
</div>


<?php require_once "./inc/footer.php"; ?>