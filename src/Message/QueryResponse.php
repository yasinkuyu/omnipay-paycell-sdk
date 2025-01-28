<?php

namespace Omnipay\PaycellSDK\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Paycell SDK Query Response
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell-sdk
 */
class QueryResponse extends AbstractResponse
{
    /**
     * Check if the query was successful.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data->responseHeader) && $this->data->responseHeader->responseDescription === "Success";
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
     * @return int|null
     */
    public function getResponseCode()
    {
        return $this->data->responseHeader->responseCode ?? null;
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
     * Get the amount.
     *
     * @return float|null
     */
    public function getAmount()
    {
        return $this->data->amount ?? null;
    }

    /**
     * Get the currency.
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->data->currency ?? null;
    }

    /**
     * Get the approval code.
     *
     * @return string|null
     */
    public function getApprovalCode()
    {
        return $this->data->approvalCode ?? null;
    }

    /**
     * Get the payment reference number.
     *
     * @return string|null
     */
    public function getPaymentReferenceNumber()
    {
        return $this->data->paymentReferenceNumber ?? null;
    }

    /**
     * Get the payment date.
     *
     * @return string|null
     */
    public function getPaymentDate()
    {
        return $this->data->paymentDate ?? null;
    }

    /**
     * Get the reconciliation date.
     *
     * @return string|null
     */
    public function getReconciliationDate()
    {
        return $this->data->reconcilationDate ?? null;
    }

    /**
     * Get the status.
     *
     * @return int|null
     */
    public function getStatus()
    {
        return $this->data->status ?? null;
    }

    /**
     * Get the status explanation.
     *
     * @return string|null
     */
    public function getStatusExplanation()
    {
        return $this->data->statusExplanation ?? null;
    }

    /**
     * Get the payment method details.
     *
     * @return array|null
     */
    public function getPaymentMethod()
    {
        return isset($this->data->paymentMethod) ? [
            'paymentMethodId' => $this->data->paymentMethod->paymentMethodId ?? null,
            'paymentMethodNumber' => $this->data->paymentMethod->paymentMethodNumber ?? null,
            'paymentMethodType' => $this->data->paymentMethod->paymentMethodType ?? null,
        ] : null;
    }

    /**
     * Get the merchant ID.
     *
     * @return string|null
     */
    public function getMerchantId()
    {
        return $this->data->merchantId ?? null;
    }

    /**
     * Get the terminal ID.
     *
     * @return string|null
     */
    public function getTerminalId()
    {
        return $this->data->terminalId ?? null;
    }

    /**
     * Get the refunded amount.
     *
     * @return float|null
     */
    public function getRefundedAmount()
    {
        return $this->data->refundedAmount ?? null;
    }
}