<style>
    body {
        white-space: break-spaces;
        font-family: monospace;
        line-height: 16px;
    }
    /* Selecting text after colon and applying bold effect */
    ::after {
        font-weight: bold;
        display: inline;
    }
</style>

<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../../../../vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('Paycell');
$gateway->setPrefix(666);
$gateway->setApplicationName('PAYCELLTEST');
$gateway->setApplicationPwd('PaycellTestPassword');
$gateway->setSecureCode('PAYCELL12345');
$gateway->setEulaID(17);
$gateway->setMerchantCode(9998);

$gateway->setMsisdn('905444170819');

$gateway->setTestMode(true);

# https://paycell.com.tr/test-kredi-kartlari
# Akbank 3D pass: a