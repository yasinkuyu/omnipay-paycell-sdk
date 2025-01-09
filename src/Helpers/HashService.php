<?php
namespace Omnipay\Paycell\Helpers;

/**
 * Paycell
 * 
 * (c) Yasin Kuyu
 * 2024, insya.com
 * http://www.github.com/yasinkuyu/omnipay-paycell-sdk
 */
class HashService {
    private array $parameters;
    
    public function __construct(array $parameters) {
        $this->parameters = $parameters;
        
        // Validate required parameters
        $requiredParams = ['secureCode', 'terminalCode', 'paymentReferenceNumber', 
                          'amount', 'paymentSecurity', 'hostAccount', 'currency'];
                          
        foreach($requiredParams as $param) {
            if(!isset($parameters[$param])) {
                throw new \InvalidArgumentException("Missing required parameter: $param");
            }
        }
    }

    public function generateRequestHash(string $transactionId, string $transactionDateTime): string {
        // Generate initial security data hash
        $securityData = $this->hash($this->parameters['secureCode'] . $this->parameters['terminalCode']);
        
        // Build data string with required parameters
        $data = implode('', [
            $this->parameters['paymentReferenceNumber'],
            $this->parameters['terminalCode'], 
            $this->parameters['amount'],
            $this->parameters['currency'],
            $this->parameters['paymentSecurity'],
            $this->parameters['hostAccount']
        ]);

        // Add installment plan data if present
        if(!empty($this->parameters['installmentPlan'])) {
            $data .= $this->processInstallmentPlan($this->parameters['installmentPlan']);
        }

        // Append security data and generate final hash
        return $this->hash($data . $securityData);
    }

    private function processInstallmentPlan(array $installmentPlan): string {
        usort($installmentPlan, fn($a, $b) => $a['lineId'] - $b['lineId']);
        
        return array_reduce($installmentPlan, function($carry, $item) {
            return $carry . implode('', [
                $item['lineId'],
                $item['paymentMethodType'],
                $item['cardBrand'],
                $item['count'],
                $item['amount']
            ]);
        }, '');
    }

    private function hash(string $data): string {
        return base64_encode(hash('sha256', $data, true));
    }
}
