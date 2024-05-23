<?php


use Omnipay\Omnipay;

$gateway = Omnipay::create('PayPal_Express');
$gateway->setUsername('your_paypal_api_username');
$gateway->setPassword('your_paypal_api_password');
$gateway->setSignature('your_paypal_api_signature');

$response = $gateway->purchase([
    'amount' => '10.00',
    'currency' => 'USD',
    'returnUrl' => 'https://www.example.com/success',
    'cancelUrl' => 'https://www.example.com/cancel',
])->send();

if ($response->isRedirect()) {
    $response->redirect(); // Müşteriyi ödeme ekranına yönlendir
} else {
    echo $response->getMessage(); // Hata mesajı göster
}