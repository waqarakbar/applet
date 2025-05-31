<?php

function encryptData($data, $key) {
    $ivlen = openssl_cipher_iv_length('AES-256-CBC');
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
    return base64_encode($iv . $ciphertext);
}

function decryptData($data, $key) {
    $data = base64_decode($data);
    $ivlen = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($data, 0, $ivlen);
    $ciphertext = substr($data, $ivlen);
    return openssl_decrypt($ciphertext, 'AES-256-CBC', $key, 0, $iv);
}