<?php

$configFile = 'config.json';

if (file_exists($configFile)) {

    $appConfig = json_decode(file_get_contents($configFile), true);

    if ($appConfig === null) {
        die('Error decoding JSON in config file.');
    }

} else {
    die('Config file not found.');
}

$clientId = $appConfig["clientId"];
$client_secret = $appConfig["clientSecret"];
$grantType = 'authorization_code';

// Get the code from the URL
$code = $_GET['code'];
// exit();

$getAccessToken = getToken($clientId, $client_secret, $grantType, $code);

// var_dump($getAccessToken);


//function for getting access token 
function getToken($clientId, $client_secret, $grantType, $code)
{

    $data = array(
        'client_id' => $clientId,
        'client_secret' => $client_secret,
        'grant_type' => $grantType,
        'code' => $code,
        'user_type' => 'Location',
    );

    $postData = http_build_query($data);

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
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded'
        ),
    );

    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        die('Curl error: ' . curl_error($curl));
    }

    curl_close($curl);

    $responseData = json_decode($response, true);

    if ($responseData === null) {
        die('Error decoding JSON response');
    }

    return $responseData;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token Data</title>

    <style>
        button{
            padding: 5px 15px;
            margin-bottom: 2px;
            /* background-color: green; */
        }
    </style>
</head>
<body>


    <?php $sn = 1; ?>

    <div style="margin-bottom: 15px;">
        <label for="">
            <strong>Client ID</strong>&nbsp;&nbsp;
            <button id="copyButton<?php echo $sn; ?>">Copy</button>&nbsp;&nbsp;
                <span id="msg<?php echo $sn; ?>" style="color: green"></span>
        </label>
        <br>
        <textarea name="" class="gt_data" id="textarea<?php echo $sn; ?>" cols="100" rows="5"><?php echo $clientId; ?></textarea>
    </div>
    <?php $sn++; ?>


    <div style="margin-bottom: 15px;">
        <label for="">
            <strong>Client Secret</strong>&nbsp;&nbsp;
            <button id="copyButton<?php echo $sn; ?>">Copy</button>&nbsp;&nbsp;
                <span id="msg<?php echo $sn; ?>" style="color: green"></span>
        </label>
        <br>
        <textarea name="" class="gt_data" id="textarea<?php echo $sn; ?>" cols="100" rows="5"><?php echo $client_secret; ?></textarea>
    </div>
    <?php $sn++; ?>


    <?php foreach($getAccessToken as $gtk => $gtd): ?>

        <?php if(!in_array($gtk, ['-access_token', 'refresh_token', 'locationId'])) continue;  ?>

        <div style="margin-bottom: 15px;">
            <label for="">
                <strong><?php echo $gtk; ?></strong>&nbsp;&nbsp;
                <button id="copyButton<?php echo $sn; ?>">Copy</button>&nbsp;&nbsp;
                <span id="msg<?php echo $sn; ?>" style="color: green"></span>
            </label>
            <br>
            <textarea name="" class="gt_data" id="textarea<?php echo $sn; ?>" cols="100" rows="5"><?php echo $gtd; ?></textarea>
        </div>

        <?php $sn++; ?>

    <?php endforeach; ?>
    
    
    <div style="margin-bottom: 15px;">
        <label for="">
            <strong>Start Date</strong>&nbsp;&nbsp;
            <button id="copyButton<?php echo $sn; ?>">Copy</button>&nbsp;&nbsp;
                <span id="msg<?php echo $sn; ?>" style="color: green"></span>
        </label>
        <br>
        <textarea name="" class="gt_data" id="textarea<?php echo $sn; ?>" cols="100" rows="5">2021-01-01T00:00:00Z</textarea>
    </div>
    <?php $sn++; ?>
    
    
    <br><br>
    
    <h3><a href="http://161.35.103.238/getAppData.php">CREATE NEW TOKEN</a></h3>



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
    
    
</body>
</html>
