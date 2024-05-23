<?php

namespace Omnipay\Paycell\Message;
 
use Omnipay\Paycell\CommonParameters;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class Purchase3dRequest extends AbstractRequest
{

    use CommonParameters;

    protected $actionType = 'SALE';

    public function getData()
    {
        $cardTokenResponse = $this->getCardTokenSecure();

        $cardTokenResponse = $this->createResponse($cardTokenResponse);;

        if(!$cardTokenResponse->getCardToken()) {
            die("Invalid card token. " . $cardTokenResponse->getMessage());
        }

        return [
           "cardToken" => $cardTokenResponse->getCardToken()
        ];
    }

    public function sendData($data)
    {
        $httpResponse = $this->getThreeDSession($data);
    
        $httpResponse =  $this->createResponse($httpResponse);

        $threeDSessionId = $httpResponse->getThreeDSessionId();
        $callbackUrl = $this->getReturnUrl();

        $data1["threeDSessionId"] = $httpResponse->getThreeDSessionId();
        $data1["callbackUrl"] = $this->getReturnUrl();


     /*    echo '<html>
        <head>
        <title>iPay APM 3D-Secure Processing Page</title>
        </head>
        <body>
        
        <script type="text/javascript"></script>
        <form 
        name="topUpForm"
        action="https://omccstb.turkcell.com.tr/paymentmanagement/rest/threeDSecure"
        method="POST">
        <table>
        <td>
        threeDSessionId :
        </td>
        <td>
        <input type="Text" name="threeDSessionId" value="'. $threeDSessionId . '" size="50">
        </td>
        </tr>
        <tr>
        <td>
        callbackurl :
        </td>
        <td>
        <input type="Text" name="callbackUrl" value="http://local.paycell/callback.php">
        </td>
        </tr>
                                 <td>
        
        isPost3DResult :
        </td>
        <td>
        </td>
        </tr>
        <tr>
        <td colspan="2">
        <input type="submit" name="submit" Value="Bankaya Gönder">
        </td>
        </tr>
        
        </table>
        </form>
        <script LANGUAGE="Javascript">
        document.topUpForm.submit();
        </script>
        </body>
        </html>';
        die(); */

        $redirectContentResponse = $this->threeDSecure($data1);

        $redirectContentResponse = $this->getThreeDSessionResult($data1);

        // Create and return a response
        return $this->createResponse($redirectContentResponse);
    } 

    /**
     * Create a response object.
     *
     * @param array $data The response data
     * @return PurchaseResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
