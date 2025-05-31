<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['msg'] = '403: Access forbidden!';
    header('Location: ./login.php');
    exit;
}