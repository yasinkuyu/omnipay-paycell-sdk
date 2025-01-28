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
    echo "getAcquirerBankCode: " . $response->getAcquirerBankCode() . PHP_EOL;
    echo "getIssuerBankCode: " . $response->getIssuerBankCode() . PHP_EOL;
    echo "getInstallmentCount: " . $response->getInstallmentCount() . PHP_EOL;
    echo "getOrderId: " . $response->getOrderId() . PHP_EOL;
    echo "getPaymentSecurity: " . $response->getPaymentSecurity() . PHP_EOL;
    echo "getStatusExplanation: " . $response->getStatusExplanation() . PHP_EOL;
    echo "getAmountWithoutHP: " . $response->getAmountWithoutHP() . PHP_EOL;
    echo "getUsedHPAmount: " . $response->getUsedHPAmount() . PHP_EOL;
    echo "getEarnedHPAmount: " . $response->getEarnedHPAmount() . PHP_EOL;
    echo "getWithoutHPAmount: " . $response->getWithoutHPAmount() . PHP_EOL;
    echo "getPaymentMethod: " . var_dump($response->getPaymentMethod()) . PHP_EOL;
    echo "getMerchantId: " . $response->getMerchantId() . PHP_EOL;
    echo "getTerminalId: " . $response->getTerminalId() . PHP_EOL;

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

echo "<br>";
echo "<details><summary>Query Response Raw Data</summary>";
echo "<pre class='raw_data'><code>";
print_r($response->getData());
echo "</code></pre>";
echo "</details>";
