<?php

require 'init.php';

$threeDSessionId = $_GET['threeDSessionId'];
$misisdn = $_GET['msisdn'];

$gateway->setReferenceNumber(date("Ymdhissss")); // unique transaction reference number, order number etc... 
$gateway->setThreeDSessionId($threeDSessionId);
$gateway->setMsisdn($misisdn);

$response = $gateway->completePurchase()->send();

if ($response->isSuccessful()) {

    echo "3D Payment Successful" . PHP_EOL;

    echo PHP_EOL;

    // The transaction number to be used for return, reverse(void), and inquire(fetch) methods
    echo "ReferenceNumber: " . $gateway->getReferenceNumber() . PHP_EOL;

    echo "getMessage: " . $response->getMessage() . PHP_EOL;
    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;

    echo "getExtraParameters: " . $response->getExtraParameters() . PHP_EOL;
    echo "getCurrentStep: " . $response->getCurrentStep() . PHP_EOL;
    echo "getMdErrorMessage: " . $response->getMdErrorMessage() . PHP_EOL;
    echo "getMdStatus: " . $response->getMdStatus() . PHP_EOL;
    echo "getThreeDResult: " . $response->getThreeDResult() . PHP_EOL;
    echo "getThreeDResultDescription: " . $response->getThreeDResultDescription() . PHP_EOL;


} else {
    echo "3D Payment fail: " . $response->getMessage() . PHP_EOL;
}
