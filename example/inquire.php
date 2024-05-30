<?php

require 'init.php';

$gateway->setReferenceNumber(date("Ymdhis"));

// fetch Transation

// The transaction number to be used for return, reverse(void), and inquire(fetch) methods
$gateway->setOriginalReferenceNumber("66620240530045825252525");

$response = $gateway->inquire()->send();

if ($response->isSuccessful()) {

    echo "Inquire Successful" . PHP_EOL;

    echo PHP_EOL;

    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "getMessage: " . $response->getMessage() . PHP_EOL;
    echo "getAcquirerBankCode: " . $response->getAcquirerBankCode() . PHP_EOL;
    echo "getOrderId: " . $response->getOrderId() . PHP_EOL;

    echo "getProvisionList: <code>" . print_r($response->getProvisionList(), true) . "</code>" . PHP_EOL;

} else {
    echo "Inquire fail: " . $response->getMessage();
}
