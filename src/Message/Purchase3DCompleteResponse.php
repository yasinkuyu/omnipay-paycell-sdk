<?php

namespace Omnipay\Paycell\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell
 */
class Purchase3DCompleteResponse extends TransactionResponse
{
    /**
     * Get the isRedirect.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        // mdStatus = 1 : Tam doğrulama
        // mdStatus = 2 : Kart sahibi veya bankası sisteme kayıtlı değil
        // mdStatus = 3 : Kartın bankası sisteme kayıtlı değil
        // mdStatus = 4 : Doğrulama denemesi, kart sahibi sisteme daha sonra kayıt olmayı seçmiş
        // mdStatus = 5 : Doğrulama yapılamıyor
        // mdStatus = 6 : 3D Secure hatası
        // mdStatus = 7 : Sistem hatası
        // mdStatus = 8 : Bilinmeyen kart no
        // mdStatus = 0 : 3D Secure imzası geçersiz, doğrulama yapılamıyor, SMS şifresi yanlış veya kullanıcı iptal butonuna basmış.
        return $this->data->mdStatus == 1;
    }

    /**
     * Get the response description.
     *
     * @return string|null
     */
    public function getResponseDescription()
    {
        return $this->data->responseHeader->responseDescription ?? null;
    }

    /**
     * Get the Three D Session Id.
     * 
     * 3D doğrulama işlemine ait session ID değeridir.
     * 
     * @return string|null
     */
    public function getThreeDSessionId()
    {
        return $this->data->threeDSessionId ?? null;
    }

    /**
     * Get the card token.
     *
     * @return string|null
     */
    public function getCardToken()
    {
        return $this->data->cardToken ?? null;
    }

    /**
     * Get the hash Data.
     *
     * @return string|null
     */
    public function getHashData()
    {
        return $this->data->hashData ?? null;
    }

    /**
     * Get the transaction ID.
     *
     * @return string|null
     */
    public function getTransactionId()
    {
        return $this->data->responseHeader->transactionId ?? null;
    }
    
    /**
     * Get the response code.
     *
     * @return string|null
     */
    public function getResponseCode()
    {
        return $this->data->responseHeader->responseCode ?? null;
    }
    
    /**
     * Get the response date and time.
     *
     * @return string|null The transaction date and time.
     */
    public function getResponseDateTime() {
        return $this->data->responseHeader->responseDateTime ?? null;
    }

    /**
     * Get the current step.
     *
     * @return string|null
     */
    public function getCurrentStep()
    {
        return $this->data->currentStep ?? null;
    }

    /**
     * Get the MD error message.
     *
     * @return string|null
     */
    public function getMdErrorMessage()
    {
        return $this->data->mdErrorMessage ?? null;
    }

    /**
     * Get the MD status.
     *
     * @return string|null
     */
    public function getMdStatus()
    {
        return $this->data->mdStatus ?? null;
    }

    /**
     * Get the 3D result.
     *
     * @return string|null
     */
    public function getThreeDResult()
    {
        return $this->data->threeDOperationResult->threeDResult ?? null;
    }

    /**
     * Get the 3D result description.
     *
     * @return string|null
     */
    public function getThreeDResultDescription()
    {
        return $this->data->threeDOperationResult->threeDResultDescription ?? null;
    }

    /**
     * Get the 3D result description.
     *
     * @return string|null
     */
    public function getMessage()
    {

        $mdStatuses = [
            2 => "Kart sahibi veya bankası sisteme kayıtlı değil",
            3 => "Kartın bankası sisteme kayıtlı değil",
            4 => "Doğrulama denemesi, kart sahibi sisteme daha sonra kayıt olmayı seçmiş",
            5 => "Doğrulama yapılamıyor",
            6 => "3D Secure hatası",
            7 => "Sistem hatası",
            8 => "Bilinmeyen kart no",
            0 => "3D Secure imzası geçersiz, doğrulama yapılamıyor, SMS şifresi yanlış veya kullanıcı iptal butonuna basmış.",
        ];

        $message = isset($mdStatuses[$this->data->mdStatus]) ? ' Message: '. $mdStatuses[$this->data->mdStatus] : null;

        return ($this->data->threeDOperationResult->threeDResultDescription ?? null) . $message;


    }
}
