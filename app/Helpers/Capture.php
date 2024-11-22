<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Omnipay\Common\CreditCard;
use App\Models\Settings;
use Random\RandomException;

class Capture
{
    public $settings;

    public Request $request;

    public function __construct(Settings $settings, Request $request)
    {
        $this->settings = Settings::find(1);
        $this->request = $request;
    }

    /**
     * @throws RandomException
     */
    public function getCaptureParams(): array
    {
        $params = [
            'card' => $this->getCardInfo(),
            'orderId' => random_int(99999, 9999999),
            'amount' => $this->request->totalAmount,
            'currency' => 'TRY',
            'installment' => '',
            'clientIp' => 'xxx',
        ];

        return $this->provideMergedParams($params);
    }

    private function provideMergedParams(array $params): array
    {
        $params = array_merge($params, $this->getDefaultOptions());
        return $params;
    }

    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'terminalId' => $this->settings->terminal_id,
            'merchantId' => $this->settings->merchant_id,
            'password' => $this->settings->provision_password
        ];
    }

    private function getCardInfo(): \Omnipay\Common\CreditCard
    {
        $cardInfo = $this->getValidCard();
        $cardInfo['number'] = $this->request->cc_no;
        $cardInfo['expiryMonth'] = $this->request->cc_month;
        $cardInfo['expiryYear'] = $this->request->cc_year;
        $cardInfo['cvv'] = $this->request->cc_cvc;;
        $card = new CreditCard($cardInfo);
        $card->setEmail('y.cengiz.coskun@gmail.com');
        $card->setFirstName('Yasin Cengiz');
        $card->setLastName('Coşkun');

        return $card;
    }

    private function getValidCard(): array
    {
        return [
            'firstName' => 'Yasin Cengiz',
            'lastName' => 'Coşkun',
            'number' => '5549605007824017',
            'expiryMonth' => 12,
            'expiryYear' => 25,
            'cvv' => 460,
            'billingAddress1' => 'Atasehir',
            'billingAddress2' => '',
            'billingCity' => 'Istanbul',
            'billingPostcode' => '34000',
            'billingState' => '',
            'billingCountry' => 'TR',
            'billingPhone' => '(538) 896-1435',
            'shippingAddress1' => 'Atasehir',
            'shippingAddress2' => '',
            'shippingCity' => 'Istanbul',
            'shippingPostcode' => '34000',
            'shippingState' => '',
            'shippingCountry' => 'TR',
            'shippingPhone' => '(538) 896-1435',
        ];
    }
}
