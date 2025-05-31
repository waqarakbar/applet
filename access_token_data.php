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

if(!$_GET['code']){
    $_SESSION['msg'] = "Invalid code, please try again";
    header("Location: ./");
    die('!');
}
$code = $_GET['code'];



$data = array(
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'grant_type' => 'authorization_code',
    'code' => $code,
    'user_type' => 'Location',
);

$post_data = http_build_query($data);

$curl = curl_init();

$options = array(
    CURLOPT_URL => 'https://services.leadconnectorhq.com/oauth/token',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $post_data,
    CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Content-Type: application/x-www-form-urlencoded'
    ),
);

curl_setopt_array($curl, $options);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    $_SESSION['msg'] = 'CURL ERROR:: '.curl_error($curl);
    header('Location: ./');
    die('!');
}

curl_close($curl);

$response_data = json_decode($response, true);

if ($response_data === null) {
    $_SESSION['msg'] = 'Error decoding JSON response';
    header('Location: ./');
    die('!');
}
?>

?>
<?php require_once "./inc/header.php"; ?>
<div class="row">
    <div class="col-md-12">
        <h1>Token Data</h1>
    </div>
</div>


<?php $sn = 1; ?>

    <div class="row">
        <div class="col-md-12">
        <label for="" class="form-label">
            <strong>Client ID</strong>&nbsp;&nbsp;
            <button id="copyButton<?php echo $sn; ?>">Copy</button>&nbsp;&nbsp;
                <span id="msg<?php echo $sn; ?>" style="color: green"></span>
        </label>
        <br>
        <textarea name="" class="gt_data form-control" id="textarea<?php echo $sn; ?>" cols="100" rows="5"><?php echo $client_id; ?></textarea>
        </div>
    </div>
    <?php $sn++; ?>



    <div class="row">
        <div class="col-md-12">
            <label for="" class="form-label">
                <strong>Client Secret</strong>&nbsp;&nbsp;
                <button id="copyButton<?php echo $sn; ?>">Copy</button>&nbsp;&nbsp;
                    <span id="msg<?php echo $sn; ?>" style="color: green"></span>
            </label>
            <br>
            <textarea name="" class="gt_data form-control" id="textarea<?php echo $sn; ?>" cols="100" rows="5"><?php echo $client_secret; ?></textarea>
        </div>
    </div>
    <?php $sn++; ?>


    <?php foreach($response_data as $gtk => $gtd): ?>

        <?php if(!in_array($gtk, ['-access_token', 'refresh_token', 'locationId'])) continue;  ?>

        <div class="row">
            <div class="col-md-12">
            <label for="" class="form-label">
                <strong><?php echo $gtk; ?></strong>&nbsp;&nbsp;
                <button id="copyButton<?php echo $sn; ?>">Copy</button>&nbsp;&nbsp;
                <span id="msg<?php echo $sn; ?>" style="color: green"></span>
            </label>
            <br>
            <textarea name="" class="gt_data form-control" id="textarea<?php echo $sn; ?>" cols="100" rows="5"><?php echo $gtd; ?></textarea>
            </div>
        </div>
        <?php $sn++; ?>

    <?php endforeach; ?>
    
    <div class="row">
        <div class="col-md-12">
            <label for="" class="form-label">
                <strong>Start Date</strong>&nbsp;&nbsp;
                <button id="copyButton<?php echo $sn; ?>">Copy</button>&nbsp;&nbsp;
                    <span id="msg<?php echo $sn; ?>" style="color: green"></span>
            </label>
            <br>
            <textarea name="" class="gt_data form-control" id="textarea<?php echo $sn; ?>" cols="100" rows="5">2021-01-01T00:00:00Z</textarea>
        </div>
    </div>
    <?php $sn++; ?>


    <div class="row">
        <div class="col-md-12">
            <a href="./get_consent.php" class="btn btn-info">Generate New Token</a>
        </div>
    </div>


    <script>

        document.addEventListener('DOMContentLoaded', () => {
            const textareas = document.querySelectorAll('textarea');

            textareas.forEach(textarea => {
                const buttonId = `copyButton${textarea.id.slice(-1)}`;
                const msgId = `msg${textarea.id.slice(-1)}`;
                const button = document.getElementById(buttonId);

                button.addEventListener('click', () => {
                    // Select the text
                    textarea.select();
                    textarea.setSelectionRange(0, textarea.value.length); // For mobile support

                    try {
                        const successful = document.execCommand('copy'); // Works without HTTPS
                        if (successful) {
                            document.getElementById(msgId).innerHTML = 'Copied!';
                        } else {
                            throw new Error('Copy command failed');
                        }
                    } catch (err) {
                        console.error('Failed to copy text:', err);
                        alert('Failed to copy text. Please check browser settings.');
                    } finally {
                        textarea.selectionStart = textarea.selectionEnd = 0; // Deselect text
                    }
                });
            });
        });

    </script>

<?php require_once "./inc/footer.php"; ?>
