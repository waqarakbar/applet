<?php require_once "./inc/auth.php"; ?>
<?php require_once "./inc/functions.php"; ?>
<?php require_once "./inc/db.php"; ?>
<?php require_once "./configs.php"; ?>
<?php


?>
<?php require_once "./inc/header.php"; ?>
<div class="row">
    <div class="col-md-12">
        <h1>Help Guide</h1>
    </div>
</div>


<div class="row mt-5">
    <div class="col-md-12">

        <h4>Introduction</h4>
        <p>This applet helps in generating refresh token for GHL locations. The GHL API v2 implements oAuth flow for API token. The refresh tokens and access token are being generated using consent from each location.</p>

        <h4>How it works?</h4>
        <p>
            The first thing you need to do is create an app in GHL market place. 
            From that app, copy the client id, client secret, SSO and list of scopes. 
            Save these attributes in the <a href="./settings.php">settings</a> page.
            Once the attributes are saved, then click on <a href="./generate_token.php">generate token</a> link, it will redirect you
            to the GHL consent page. Select a location (sub-account) from the dropdown, the page will refresh and will redirect to another page showing token data.
            You can use the information displayed on the page to access the GHL APIs for that specific location.
        </p>
    </div>
</div>


<?php require_once "./inc/footer.php"; ?>