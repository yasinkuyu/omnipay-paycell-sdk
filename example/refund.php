<?php

require 'init.php';

$gateway->setReferenceNumber(date("Ymdhis"));

// The transaction number to be used for return, reverse(void), and inquire(fetch) methods
$gateway->setOriginalReferenceNumber("66620240530045825252525");

$response = $gateway->refund([
    'amount' => '10.00',
])->send();

if ($response->isSuccessful()) {

    echo "Refund Successful" . PHP_EOL;

    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "getMessage: " . $response->getMessage() . PHP_EOL;

    echo "getRetryStatusDescription: " . $response->getRetryStatusDescription() . PHP_EOL;
    echo "getReconciliationDate: " . $response->getReconciliationDate() . PHP_EOL;
    echo "getRetryStatusCode: " . $response->getRetryStatusCode() . PHP_EOL;
    echo "getApprovalCode: " . $response->getApprovalCode() . PHP_EOL;

} else {
    echo "Refund fail: " . $response->getMessage();
}