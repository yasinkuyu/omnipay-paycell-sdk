<?php

require 'init.php';

$paymentReferenceNumber = $_GET['paymentReferenceNumber'];

$gateway->setMsisdn("905355106190");

$response = $gateway->query([
    'originalPaymentReferenceNumber' => $paymentReferenceNumber,
])->send();


if ($response->isSuccessful()) {

    echo "Query Successful <br>";

    echo "<br>";

    echo "getMessage: " . $response->getResponseDescription() . PHP_EOL;
    echo "getTransactionId: " . $response->getTransactionId() . PHP_EOL;

    echo "getApprovalCode: " . $response->getApprovalCode() . PHP_EOL;
    echo "getPaymentReferenceNumber: " . $response->getPaymentReferenceNumber() . PHP_EOL;
    echo "getPaymentDate: " . $response->getPaymentDate() . PHP_EOL;
    echo "getStatus: " . $response->getStatus() . PHP_EOL;
    echo "getResponseCode: " . $response->getResponseCode() . PHP_EOL;

    echo "<br>";

    echo "Refund payment: <br>";
    echo "<a target='_blank' href='refund.php?paymentReferenceNumber=" . $response->getPaymentReferenceNumber() . "'>Refund</a><br>";
    
    echo "Reverse payment: <br>";
    echo "<a target='_blank' href='reverse.php?paymentReferenceNumber=" . $response->getPaymentReferenceNumber() . "'>Reverse</a><br>";

} else {
    echo "Query fail: " . $response->getMessage() . PHP_EOL;
    echo "<br>";

    echo "getResponseDescription: " . $response->getResponseDescription() . PHP_EOL;
    echo "getResponseCode: " . $response->getResponseCode() . PHP_EOL;
}

echo "\nQuery Response Raw Data:\n";
print_r($response->getData());
