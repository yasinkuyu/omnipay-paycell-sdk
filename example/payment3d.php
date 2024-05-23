<?php

require 'init.php';

$gateway->setMsisdn('905444170819');

# https://paycell.com.tr/test-kredi-kartlari
$response = $gateway->purchase3d([
    'amount' => '1.00',
    'currency' => 'TRY',
    'card' => [
        'number' => '4355084355084358',
        'expiryMonth' => '12',
        'expiryYear' => '26',
        'cvv' => '000' 
    ],

    "returnUrl" => "http://local.paycell/callback.php"
])->send();

echo trim($response->getRedirectContent());