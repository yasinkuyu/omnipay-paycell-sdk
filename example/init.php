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

$gateway->setTestMode(true);
