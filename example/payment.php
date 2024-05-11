<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../../../../vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('Paycell');
$gateway->setPrefix('666');
$gateway->setApplicationName('PAYCELLTEST');
$gateway->setApplicationPwd('PaycellTestPassword');
$gateway->setSecureCode('PAYCELL12345');
$gateway->setEulaID('17');
$gateway->setMerchantCode('9998');

$gateway->setTransactionId(  rand ( 10000 , 99999 )); # order id

$gateway->setTestMode(true);

# https://paycell.com.tr/test-kredi-kartlari
# Akbank 3D pass: a
$response = $gateway->purchase([
    'amount' => '10.00',
    'currency' => 'TRY',
    'card' => [
        'number' => '4355084355084358',
        'expiryMonth' => '12',
        'expiryYear' => '26',
        'cvv' => '' 
    ]
])->send();

if ($response->isSuccessful()) {
    echo "Ödeme başarılı! İşlem ID: " . $response->getTransactionId();
    echo PHP_EOL;
    echo "Mesaj: " . $response->getMessage();
} else {
    echo "Ödeme başarısız: " . $response->getMessage();
}